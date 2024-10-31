<?php

namespace Modules\User\Service;

use Core\Http\ResponseBag;
use Core\Jwt\Jwt;
use Core\Service\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Contracts\User as GoogleUser;
use Modules\User\Models\User;
use Modules\User\Objects\PendingClient;
use Modules\User\Repository\Contracts\ClientRepository;
use Modules\User\Repository\Contracts\UserRepository;
use Modules\User\Service\Contracts\ClientService as ClientServiceContract;

class ClientService extends BaseService implements ClientServiceContract
{
    protected $baseRepo;
    protected $userRepo;

    /**
     * @param  \Modules\User\Repository\Contracts\ClientRepository  $baseRepo
     * @param  \Modules\User\Repository\Contracts\UserRepository    $userRepo
     * @return void
     */
    public function __construct(ClientRepository $baseRepo, UserRepository $userRepo)
    {
        parent::__construct($baseRepo);

        $this->userRepo = $userRepo;
    }

    /**
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data)
    {
        // $accessTokenExp = $currentTime + Constant::ACCESS_TOKEN_EXP;
        // $refreshTokenExp = $currentTime + Constant::REFRESH_TOKEN_EXP;

        // $refreshToken = $this->generateToken(['exp' => $refreshTokenExp]);
        // $accessToken = $this->generateToken([
        //     'exp' => $accessTokenExp,
        //     'refresh_token' => $refreshToken,
        // ]);

        $attributes = [
            'id' => str_random(),
            'ip' => Request::ip(),
            'user_id' => $data['user_id'],
            'session_id' => Session::getId(),
            'remember_token' => Cookie::get('remember_token'),
            'token' => isset($data['token']) ? $data['token'] : null,
            'refresh_token' => isset($data['refresh_token']) ? $data['refresh_token'] : null,
            'status' => 1,
            'created_at' => current_date(),
            'updated_at' => current_date(),
            'created_time' => time(),
        ];

        return $this->baseRepo->create($attributes);
    }

    /**
     * @param  string  $id
     * @param  array   $data
     * @return bool
     */
    public function updateOne($id, array $data)
    {
        $client = $this->baseRepo->findOne(['id' => $id]);

        if (is_null($client)) {
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

        if (isset($data['status']))
            $attributes['status'] = (bool) $data['status'];
        if (isset($data['session_id']))
            $attributes['session_id'] = $data['session_id'];
        if (isset($data['remember_token']))
            $attributes['remember_token'] = $data['remember_token'];
        if (isset($data['updated_at'])) {
            $attributes['updated_at'] = $data['updated_at'];
            $attributes['updated_time'] = $data['updated_time'];
        }

        return $attributes;
    }

    /**
     * Generate a token with the given expiration time if any.
     *
     * @param  array   $data
     * @return string
     */
    public function generateToken(array $data)
    {
        return Jwt::encode($data)->hash()->token();
    }

    /**
     * Resolve login for a client using the given credentials.
     *
     * @param  array  $credentials
     * @return \Core\Http\ResponseBag
     */
    public function login(array $credentials)
    {
        $responseBag = ResponseBag::create();

        $pendingClient = PendingClient::make($credentials);

        $user = $this->attempt($pendingClient);

        if (is_null($user)) {
            $responseBag->errors = label('INVALID_LOGIN');
        }

        // If the account is not activated then the user
        // can't login into the application.
        elseif ($user->active === 0) {
            $responseBag->errors = label('ACCOUNT_NOT_ACTIVATED');
        }

        if ($responseBag->isNotEmptyError()) {
            return $responseBag;
        }

        $client = $this->baseRepo->findOne(['user_id' => $user->id]);

        $timed = time() - ($client->created_time ?? 0);
        $sessionLifetime = config('session.lifetime') * 60;

        // If the user was login into the previous application,
        // then we will check the start time login and the session lifetime,
        // if it is valid then we must delete the previous session.
        if (! is_null($client) && $timed >= $sessionLifetime) {
            $this->baseRepo->deleteOne(['user_id' => $user->id]);
        }

        // If the user login into the application on another device,
        // then we will check the current session or IP address if any,
        // if it is valid the we force must the give an error for the user know.
        elseif (! is_null($client) && ($client->ip !== Request::ip() ||
            $client->session_id !== Session::getId())) {
            $responseBag->errors = label('LOGIN_ON_ANOTHER_DEVICE');
        }

        if ($responseBag->isEmptyError()) {
            Auth::login($user, $pendingClient->remember);

            $this->create(['user_id' => $user->id]);

            $responseBag->status(200)->data(['success' => true]);
        }

        return $responseBag;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  \Modules\User\Objects\PendingClient  $client
     * @return \Modules\User\Models\User|null
     */
    protected function attempt(PendingClient $client)
    {
        $user = $this->userRepo->findOne([
            '$or' => [['username' => $client->username], ['email' => $client->username]]
        ]);

        $validated = ! is_null($user) && Hash::check(
            $client->password, $user->password
        );

        return $validated ? $user : null;
    }

    /**
     * Resolve login for a client using the given Google account.
     *
     * @param  \Laravel\Socialite\Contracts\User  $googleUser
     * @return void
     */
    public function loginByGoogle(GoogleUser $googleUser)
    {
        $user = $this->userRepo->findOne(['id' => $googleUser->id]);

        if (is_null($user)) {
            $username = explode('@', $googleUser->email)[0];
            $password = $username.label('DEFAULT_PASSWORD');

            $user = $this->userRepo->create([
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'image' => $googleUser->avatar,
                'email' => $googleUser->email,
                'username' => $username,
                'password' => $password,
                'active' => 1,
                'roles' => [1],
            ]);
        }

        Auth::login($user);

        $client = $this->baseRepo->findOne(['user_id' => $user->id]);

        $timed = time() - ($client->created_time ?? 0);
        $sessionLifetime = config('session.lifetime') * 60;

        // If the user was login into the previous application,
        // then we will check the start time login and the session lifetime,
        // if it is valid then we must delete the previous session.
        if (! is_null($client) && $timed >= $sessionLifetime) {
            $this->baseRepo->deleteOne(['user_id' => $user->id]);
        } else {
            $this->create([
                'user_id' => $user->id,
                'token' => $googleUser->token,
                'refresh_token' => $googleUser->refresh_token,
            ]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param \Modules\User\Models\User  $user
     * @return void
     */
    public function logout(User $user)
    {
        Auth::logout();

        $this->baseRepo->deleteOne(['user_id' => $user->id]);
        $this->userRepo->updateOne(['id' => $user->id], ['remember_token' => null]);
    }
}