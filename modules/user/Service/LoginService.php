<?php

namespace Modules\User\Service;

use Core\Constant;
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
use Modules\User\Repository\Contracts\LoginRepository;
use Modules\User\Repository\Contracts\UserRepository;
use Modules\User\Service\Contracts\LoginService as LoginServiceContract;

class LoginService extends BaseService implements LoginServiceContract
{
    protected $baseRepo;
    protected $userRepo;

    /**
     * @param  \Modules\User\Repository\Contracts\LoginRepository  $baseRepo
     * @param  \Modules\User\Repository\Contracts\UserRepository   $userRepo
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
            'token' => isset_if($data, 'token'),
            'refresh_token' => isset_if($data, 'refresh_token'),
            'status' => 1,
            'created_at' => current_date(),
            'updated_at' => current_date(),
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
     * @return \Core\Http\ResponseBag
     */
    public function withAccount(array $credentials)
    {
        $responseBag = ResponseBag::create();

        $pendingClient = PendingClient::make($credentials);

        $user = $this->attempt($pendingClient);

        if (is_null($user)) {
            $responseBag->errors = config('user.label.INVALID_LOGIN');
        }

        // If the account is not activated then the user
        // can't login into the application.
        elseif ($user->active === 0) {
            $responseBag->errors = config('user.label.ACCOUNT_NOT_ACTIVATED');
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
            $this->baseRepo->delete(['user_id' => $user->id]);
        }

        // If the user login into the application on another device,
        // then we will check the current session or IP address if any,
        // if it is valid the we force must the give an error for the user know.
        elseif (! is_null($client) && ($client->ip !== Request::ip() ||
            $client->session_id !== Session::getId())) {
            $responseBag->errors = config('user.label.LOGIN_ON_ANOTHER_DEVICE');
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
            $password = $username.label('DEFAULT_PASSWORD');

            $user = $this->userRepo->create([
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'image' => $googleUser->avatar,
                'email' => $googleUser->email,
                'username' => $username,
                'password' => $password,
                'active' => 1,
                'roles' => [Constant::MEMBER_ROLE],
            ]);
        }

        $deleted = false;

        $client = $this->baseRepo->findOne(['user_id' => $user->id]);

        $timed = time() - ($client->created_time ?? 0);
        $sessionLifetime = config('session.lifetime') * 60;

        // If the user was login into the previous application,
        // then we will check the start time login and the session lifetime,
        // if it is valid then we must delete the previous session.
        if (! is_null($client) && $timed >= $sessionLifetime) {
            $deleted = $this->baseRepo->delete(['user_id' => $user->id]);
        }

        Auth::login($user);

        if (is_null($client) || $deleted) {
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