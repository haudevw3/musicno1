<?php

namespace Modules\User\Service;

use Core\Http\Response;
use Core\Jwt\Jwt;
use Core\Service\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Contracts\User as GoogleUser;
use Modules\User\Constant;
use Modules\User\Models\User;
use Modules\User\Repository\Contracts\LoginRepository;
use Modules\User\Repository\Contracts\UserRepository;
use Modules\User\Service\Contracts\LoginService as LoginServiceContract;

class LoginService extends BaseService implements LoginServiceContract
{
    protected $baseRepo;
    protected $userRepo;

    /**
     * @param  \Modules\User\Repository\Contracts\LoginRepository                     $baseRepo
     * @param  \Modules\User\Repository\Contracts\UserRepository                      $userRepo
     * @return void
     */
    public function __construct(LoginRepository $baseRepo, UserRepository $userRepo)
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
        $attributes = [
            'id' => str_random(),
            'ip' => Request::ip(),
            'user_id' => $data['user_id'],
            'session_id' => Session::getId(),
            'remember_token' => Cookie::get('remember_token'),
            'created_at' => date_at(),
            'updated_at' => date_at(),
            'created_time' => time(),
        ];

        return $this->baseRepo->create($attributes);
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
     * Log a user into the application with the given credentials.
     *
     * @param  array  $credentials
     * @return \Core\Http\Response
     */
    public function withAccount(array $credentials)
    {
        $response = Response::create();

        $credentials = $this->filterCredentials($credentials);

        $user = $this->attempt($credentials);

        if (is_null($user)) {
            $response->errors = config('user.label.INVALID_LOGIN');
        }

        // If the account is not verified then the user can't login into the application.
        elseif ($user->verified == 0) {
            $response->errors = config('user.label.ACCOUNT_NOT_VERIFIED');
        }

        if ($response->isNotEmptyErrors()) {
            return $response;
        }

        $login = $this->baseRepo->findOne(['user_id' => $user->id]);

        // If the user was login into the previous application,
        // then we will check the start time login and the session lifetime,
        // if it is valid then we must delete the previous session.
        if (! is_null($login) &&
           (time() - $login->created_time >= config('session.lifetime') * 60)) {
            $this->baseRepo->delete(['user_id' => $user->id]);
        }

        // If the user logs into the application on another device,
        // then we will check the current session or IP address if any.
        // If it is valid then we force give an error for the user to know.
        elseif (! is_null($login) &&
               ($login->ip != Request::ip() || $login->session_id !== Session::getId())) {
            $response->errors = config('user.label.LOGIN_ON_ANOTHER_DEVICE');
        }

        if ($response->isEmptyErrors()) {
            Auth::login($user, $credentials['remember']);

            $this->create(['user_id' => $user->id]);

            $response->setStatus(200)->setData([
                'success' => true,
                'user_id' => $user->id,
            ]);
        }

        return $response;
    }

    /**
     * Filter with the given credentials.
     *
     * @param  array  $credentials
     * @return array
     */
    protected function filterCredentials(array $credentials)
    {
        return [
            'username' => trim($credentials['username']),
            'password' => trim($credentials['password']),
            'remember' => $credentials['remember'] === 'true' ? true : false,
        ];
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @return \Modules\User\Models\User|null
     */
    protected function attempt(array $credentials)
    {
        $username = $credentials['username'];

        $user = $this->userRepo->findOne([
            '$or' => [['username' => $username], ['email' => $username]]
        ]);

        $validated = ! is_null($user) && Hash::check(
            $credentials['password'], $user->password
        );

        return $validated ? $user : null;
    }

    /**
     * Log a user into the application with the given Google account.
     *
     * @param  \Laravel\Socialite\Contracts\User  $googleUser
     * @return void
     */
    public function withGoogle(GoogleUser $googleUser)
    {
        $user = $this->userRepo->findOne(['id' => $googleUser->id]);

        if (is_null($user)) {
            $username = explode('@', $googleUser->email)[0];
            $password = $username.config('label.DEFAULT_PASSWORD');

            $user = $this->userRepo->create([
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'image' => $googleUser->avatar,
                'email' => $googleUser->email,
                'username' => $username,
                'password' => $password,
                'verified' => 1,
                'roles' => [Constant::MEMBER_ROLE],
            ]);
        }

        $deleted = false;

        $login = $this->baseRepo->findOne(['user_id' => $user->id]);

        // If the user was login into the previous application,
        // then we will check the start time login and the session lifetime,
        // if it is valid then we must delete the previous session.
        if (! is_null($login) &&
           (time() - $login->created_time >= config('session.lifetime') * 60)) {
            $deleted = $this->baseRepo->delete(['user_id' => $user->id]);
        }

        Auth::login($user);

        if (is_null($login) || $deleted) {
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

        $this->baseRepo->delete(['user_id' => $user->id]);
        $this->userRepo->update(['id' => $user->id], ['remember_token' => null]);
    }
}