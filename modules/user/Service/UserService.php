<?php

namespace Modules\User\Service;

use Core\Constant;
use Core\Http\ResponseBag;
use Core\Service\BaseService;
use Core\Support\DataBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Modules\User\Repository\Contracts\UserRepository;
use Modules\User\Service\Contracts\UserService as UserServiceContract;
use Modules\User\Traits\Mailer;

class UserService extends BaseService implements UserServiceContract
{
    use Mailer;

    /**
     * @param  \Modules\User\Repository\Contracts\UserRepository  $baseRepo
     * @return void
     */
    public function __construct(UserRepository $baseRepo)
    {
        parent::__construct($baseRepo);
    }

    /**
     * @param  array  $data
     * @param  bool   $needSendMail
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data, $needSendMail = false)
    {
        $attributes = [
            'id' => isset($data['id']) ? $data['id'] : str_random(),
            'ip' => Request::ip(),
            'name' => str_ucwords($data['name']),
            'username' => str_filter($data['username']),
            'password' => Hash::make(str_filter($data['password'])),
            'email' => str_filter($data['email']),
            'roles' => isset($data['roles']) ? $data['roles'] : [0],
            'image' => isset($data['image']) ? $data['image'] : null,
            'active' => isset($data['active']) ? $data['active'] : 0,
            'created_at' => current_date(),
            'updated_at' => current_date(),
            'created_time' => time(),
            'time_send_mail' => time(),
            'token_send_mail' => str_random('int'),
            'count_send_mail' => 1,
        ];

        $user = $this->baseRepo->create($attributes);

        if ($needSendMail) {
            $this->sendMailToVerify($user);
        }

        return $user;
    }

    /**
     * @param  string  $id
     * @param  array   $data
     * @return bool
     */
    public function updateOne($id, array $data)
    {
        $user = $this->baseRepo->findOne(['id' => $id]);

        if (is_null($user)) {
            return false;
        }

        return $this->baseRepo->updateOne(
            ['id' => $id], $this->filterData($data)
        );
    }

    /**
     * @param  array  $data
     * @return array
     */
    protected function filterData(array $data)
    {
        $attributes = [];

        if (isset($data['name']))
            $attributes['name'] = str_ucwords($data['name']);
        if (isset($data['username']))
            $attributes['username'] = str_filter($data['username']);
        if (isset($data['email']))
            $attributes['email'] = str_filter($data['email']);
        if (isset($data['image']))
            $attributes['image'] = str_filter($data['image']);
        if (isset($data['roles']))
            $attributes['roles'] = (array) $data['roles'];
        if (isset($data['active']))
            $attributes['active'] = intval($data['active']);
        if (isset($data['updated_at']))
            $attributes['updated_at'] = str_filter($data['updated_at']);
        if (isset($data['password']) && $data['password'] !== label('PASSWORD_DEFAULT'))
            $attributes['password'] = Hash::make(str_filter($data['password']));
        if (isset($data['time_send_mail'])) {
            $attributes['time_send_mail'] = intval($data['time_send_mail']);
            $attributes['token_send_mail'] = intval($data['token_send_mail']);
            $attributes['count_send_mail'] = intval($data['count_send_mail']);
        }

        return $attributes;
    }

    /**
     * @param  array  $data
     * @return array
     */
    public function verifyAccount(array $data)
    {
        $responseBag = ResponseBag::create();

        $id = $data['id'];
        $user = $this->baseRepo->findOne(['id' => $id]);

        $timed = time() - $user->time_send_mail;

        if (is_null($user)) {
            $responseBag->errors = label('INVALID_USER');
        }

        // If the input value is different from the token value sent mail,
        // then it will be invalid.
        elseif ($user->token_send_mail != $data['token_send_mail']) {
            $responseBag->errors = label('INVALID_TOKEN');
        }

        // If the input value is valid but the token expiration time
        // is larger than the default value, then it is invalid.
        elseif ($timed > Constant::TIME_EXPIRE_TOKEN) {
            $responseBag->errors = label('TOKEN_NOT_EXPIRED');
        }

        // This case satisfies the conditions. We will update some information
        // and redirect the user to the application.
        else {
            $data = [
                'active' => 1,
                'roles' => [Constant::MEMBER_ROLE],
                'token_send_mail' => '',
                'time_send_mail' => 0,
                'count_send_mail' => 0,
            ];

            $this->baseRepo->updateOne(['id' => $id], $data);

            $responseBag->status(200)->data(['success' => true]);
        }

        return $responseBag;
    }

    /**
     * @param  string  $email
     * @return \Core\Http\ResponseBag
     */
    public function forgetPassword(string $email)
    {
        $dataBag = DataBag::create();
        $responseBag = ResponseBag::create();

        $user = $this->baseRepo->findOne(['email' => $email]);

        $timed = time() - $user->time_send_mail;

        // If the account is not activated then the user
        // can't use this function.
        if ($user->active === 0) {
            $responseBag->errors = label('ACCOUNT_NOT_ACTIVATED');
        }

        // If the current time minus the time sent mail on before,
        // if it's larger than with the given default value and the number of mailings is the maximum.
        // We will send mail to the user for them to verify.
        elseif (($timed >= Constant::TIME_OF_ONE_DAY) &&
                ($user->count_send_mail == Constant::LIMITED_SEND_MAIL_FORGET_PASSWORD)) {
            $dataBag->set([
                'token_send_mail' => str_random('string', 8),
                'time_send_mail' => time(),
                'count_send_mail' => 1
            ]);
        }

        // One day, we just sent mail to the user of the maximum is one times.
        // If the user exceeds the limit allowed then we force them wait to the next day.
        elseif ($user->count_send_mail >= Constant::LIMITED_SEND_MAIL_FORGET_PASSWORD) {
            $responseBag->errors = label('REQUEST_NOT_EXPIRED');
        }
        
        else {
            $dataBag->set([
                'token_send_mail' => str_random('string', 8),
                'time_send_mail' => time(),
                'count_send_mail' => $user->count_send_mail + 1
            ]);
        }

        if ($dataBag->isNotEmpty()) {
            $user->token_send_mail = $dataBag->token_send_mail;
            
            $dataBag->password = Hash::make($dataBag->token_send_mail);

            $this->baseRepo->updateOne(['id' => $user->id], $dataBag->all());

            $this->sendMailToVerify($user, [
                'subject' => label('EMAIL_SUBJECT_FORGET_PASSWORD'),
                'content' => label('EMAIL_CONTENT_FORGET_PASSWORD'),
                'url' => route('login-page'),
                'btn_name' => 'Link đăng nhập',
            ]);

            $responseBag->status(200)->data(['success' => label('SENT_PASSWORD')]);
        }

        return $responseBag;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\ResponseBag
     */
    public function refreshTokenToSendMail(string $id)
    {
        $dataBag = DataBag::create();
        $responseBag = ResponseBag::create();

        $user = $this->baseRepo->findOne(['id' => $id]);

        $timed = time() - $user->time_send_mail;

        if (is_null($user)) {
            $responseBag->errors = label('INVALID_USER');
        }

        // If the current time minus the time sent mail on before,
        // if it's larger than with the given default value and the number of mailings is the maximum.
        // We will send mail to the user for them to verify.
        elseif (($timed >= Constant::TIME_OF_ONE_DAY) &&
                ($user->count_send_mail == Constant::LIMITED_SEND_MAIL_VERIFY_ACCOUNT)) {
            $dataBag->set([
                'token_send_mail' => str_random('int'),
                'time_send_mail' => time(),
                'count_send_mail' => 1
            ]);
        }

        // One day, we just sent mail to the user of the maximum is three times.
        // If the user exceeds the limit allowed then we force them wait to the next day.
        elseif ($user->count_send_mail >= Constant::LIMITED_SEND_MAIL_VERIFY_ACCOUNT) {
            $responseBag->errors = label('LIMITED_SEND_MAIL');
        }

        // If the time of token value has still not yet expiration time,
        // then we will not send mail to the user. We want to ensure that,
        // every process must is valid.
        elseif ($timed <= Constant::TIME_EXPIRE_TOKEN) {
            $responseBag->errors = label('TOKEN_NOT_EXPIRED');
        }
        
        else {
            $dataBag->set([
                'token_send_mail' => str_random('int'),
                'time_send_mail' => time(),
                'count_send_mail' => $user->count_send_mail + 1
            ]);
        }

        if ($dataBag->isNotEmpty()) {
            $user->token_send_mail = $dataBag->token_send_mail;

            $this->baseRepo->updateOne(['id' => $id], $dataBag->all());
            
            $this->sendMailToVerify($user);

            $message = preg_replace(
                ['/{total}/', '/{number}/'],
                [$dataBag->count_send_mail, Constant::LIMITED_SEND_MAIL_VERIFY_ACCOUNT - $dataBag->count_send_mail],
                label('NUMBER_OF_MAILINGS'),
            );

            $responseBag->status(200)->add($message, 'success');
        }

        return $responseBag;
    }
}