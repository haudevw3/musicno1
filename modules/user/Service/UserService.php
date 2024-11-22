<?php

namespace Modules\User\Service;

use Core\Http\Response;
use Core\Service\BaseService;
use Core\Support\DataBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Modules\User\Constant;
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
     * @return \Modules\User\Models\User
     */
    public function create(array $data, $needSendMail = false)
    {
        $attributes = [
            'id' => str_random(),
            'ip' => Request::ip(),
            'name' => str_ucwords(isset_if($data['name'], 'trim')),
            'username' => isset_if($data['username'], 'trim'),
            'password' => Hash::make($data['password']),
            'email' => isset_if($data['email'], 'trim'),
            'image' => isset_if($data['image'], 'trim'),
            'roles' => [0],
            'created_at' => date_at(),
            'updated_at' => date_at(),
            'created_time' => time(),
            'count' => 1,
            'token' => str_random('int'),
            'token_expires_at' => time(),
            'verified' => 0,
        ];

        $user = $this->baseRepo->create($attributes);

        // if ($needSendMail) {
        //     $this->sendMailToVerify($user);
        // }

        return $user;
    }

    /**
     * @param  string  $id
     * @param  array   $data
     * @return \Core\Http\Response
     */
    public function updateOne($id, array $data)
    {
        $response = Response::create();

        $user = $this->baseRepo->findOne($id);

        if (is_null($user)) {
            $response->errors = config('user.label.NOT_FOUND_USER');
        }
        
        else {
            $this->baseRepo->updateOne($id, $this->filterData($data));

            $response->setStatus(200)->setData([
                'success' => config('user.label.UPDATE_SUCCESS')
            ]);
        }

        return $response;
    }

    /**
     * @param  array  $data
     * @return array
     */
    protected function filterData(array $data)
    {
        $attributes['updated_at'] = date_at();

        foreach ($data as $key => $value) {
            if ($key == 'name') {
                $attributes[$key] = str_ucwords(trim($value));
            } elseif ($key == 'roles') {
                $attributes[$key] = is_array($value) ? $value : [$value];
            } elseif (in_array($key, ['username', 'email', 'image'])) {
                $attributes[$key] = trim($value);
            } elseif ($key == 'password' && $value != config('label.DEFAULT_PASSWORD')) {
                $attributes[$key] = Hash::make($value);
            }
        }

        return $attributes;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function deleteOne($id)
    {
        $response = Response::create();

        $user = $this->baseRepo->findOne($id);

        if (is_null($user)) {
            $response->errors = config('user.label.NOT_FOUND_USER');
        }
        
        else {
            $this->baseRepo->deleteOne($id);

            $response->setStatus(200)->setData([
                'success' => config('user.label.DELETE_SUCCESS')
            ]);
        }

        return $response;
    }

    /**
     * @param  array  $ids
     * @return \Core\Http\Response
     */
    public function deleteMany(array $ids)
    {
        $response = Response::create();

        foreach ($ids as $key => $id) {
            $ids[$key] = $this->baseRepo::createObjectId($id);
        }

        $this->baseRepo->delete(['_id' => ['$in' => $ids]]);

        return $response->setStatus(200)->setData([
            'success' => config('user.label.DELETE_SUCCESS')
        ]);
    }

    /**
     * @param  array  $data
     * @return \Core\Http\Response
     */
    public function verifyAccount(array $data)
    {
        $response = Response::create();

        $user = $this->baseRepo->findOne(['id' => $data['id']]);

        if (is_null($user)) {
            $response->errors = config('user.label.NOT_FOUND_USER');
        }

        // If the given token is different from the token
        // of the user to verify, then it is invalid.
        elseif ($user->token != $data['token']) {
            $response->errors = config('user.label.INVALID_TOKEN');
        }

        // If the current time minus "token expires at" is larger than
        // the token expiration time, then it's expired.
        elseif (time() - $user->token_expires_at > Constant::TOKEN_EXPIRATION_TIME) {
            $response->errors = config('user.label.TOKEN_EXPIRED');
        }

        else {
            $data = [
                'roles' => [Constant::MEMBER_ROLE],
                'verified' => 1,
                'count' => 0,
                'token' => 0,
                'token_expires_at' => 0,
            ];

            $this->baseRepo->updateOne($user->_id, $data);

            Auth::login($user);

            $response->setStatus(200)->setData(['success' => true]);
        }

        return $response;
    }

    /**
     * @param  string  $id
     * @return \Core\Http\Response
     */
    public function refreshTokenToSendMail(string $id)
    {
        $dataBag = DataBag::create();
        $response = Response::create();

        $user = $this->baseRepo->findOne(['id' => $id]);

        $timed = time() - $user->token_expires_at ?? 0;

        if (is_null($user)) {
            $response->errors = config('user.label.NOT_FOUND_USER');
        }

        // If a day has passed since the last email was sent,
        // and the user has reached the maximum number of allowed email attempts,
        // then we'll reset this action for the user to execute it.
        elseif ($timed >= Constant::TIME_OF_ONE_DAY &&
                $user->count == Constant::LIMITED_SEND_EMAIL) {
            $dataBag->set([
                'count' => 1,
                'token' => str_random('int'),
                'token_expires_at' => time(),
            ]);
        }

        // If the time of token value has still no expiration time,
        // then we will not send mail to the user when they execute this function.
        // We want to ensure that, every process must be valid.
        elseif ($timed <= Constant::TOKEN_EXPIRATION_TIME) {
            $response->errors = config('user.label.TOKEN_NOT_EXPIRED');
        }

        // A day, we just allow the user to execute this function is maximum of three times.
        // If the user exceeds the limit allowed then we force them wait to next day.
        elseif ($user->count >= Constant::LIMITED_SEND_EMAIL) {
            $response->errors = config('user.label.LIMITED_SEND_EMAIL');
        }
        
        else {
            $dataBag->set([
                'count' => $user->count + 1,
                'token' => str_random('int'),
                'token_expires_at' => time(),
            ]);
        }

        if ($dataBag->isNotEmpty()) {
            $user->token = $dataBag->token;

            $this->baseRepo->updateOne($user->_id, $dataBag->all());

            // $this->sendMailToVerify($user);

            $message = preg_replace(
                ['/{total}/', '/{number}/'],
                [$dataBag->count, Constant::LIMITED_SEND_EMAIL - $dataBag->count],
                config('user.label.EMAIL_SEND_STATUS'),
            );

            $response->setStatus(200)->setData(['success' => $message]);
        }

        return $response;
    }

    /**
     * @param  string  $email
     * @return \Core\Http\Response
     */
    public function forgetPassword(string $email)
    {
        $dataBag = DataBag::create();
        $response = Response::create();

        $user = $this->baseRepo->findOne(['email' => $email]);

        // If a day has passed since the last email was sent,
        // and the user has reached the maximum number of allowed email attempts,
        // then we'll reset this action for the user to execute it.
        if ((time() - $user->token_expires_at >= Constant::TIME_OF_ONE_DAY &&
            $user->count == Constant::LIMITED_SEND_EMAIL_FORGET_PASSWORD) ||
            $user->count == 0) {
            $dataBag->set([
                'count' => 1,
                'token' => str_random('string', 8),
                'token_expires_at' => time(),
            ]);
        }

        // A day, we just allow the user to execute this function is maximum of one times.
        // If the user exceeds the limit allowed then we force them wait to next day.
        elseif ($user->count >= Constant::LIMITED_SEND_EMAIL_FORGET_PASSWORD) {
            $response->errors = config('user.label.REQUEST_FORGET_PASSWORD_NOT_EXPIRED');
        }

        if ($dataBag->isNotEmpty()) {
            $user->token = $dataBag->token;
            
            $dataBag->password = Hash::make($dataBag->token);

            $this->baseRepo->updateOne($user->_id, $dataBag->all());

            // $this->sendMailToVerify($user, [
            //     'subject' => config('user.label.EMAIL_SUBJECT_FORGET_PASSWORD'),
            //     'content' => config('user.label.EMAIL_CONTENT_FORGET_PASSWORD'),
            //     'url' => route('login-page'),
            //     'btn_name' => 'Link đăng nhập',
            // ]);

            $response->setStatus(200)->setData([
                'success' => config('user.label.SENT_NEW_PASSWORD')
            ]);
        }

        return $response;
    }
}