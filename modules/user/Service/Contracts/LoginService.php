<?php

namespace Modules\User\Service\Contracts;

use Laravel\Socialite\Contracts\User as GoogleUser;
use Modules\User\Models\User;

interface LoginService
{
    /**
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Generate a token with the given expiration time if any.
     *
     * @param  array   $data
     * @return string
     */
    public function generateToken(array $data);
    
    /**
     * Log a user into the application with the given credentials.
     *
     * @param  array  $credentials
     * @return \Core\Http\Response
     */
    public function withAccount(array $credentials);

    /**
     * Log a user into the application with the given Google account.
     *
     * @param  \Laravel\Socialite\Contracts\User  $googleUser
     * @return void
     */
    public function withGoogle(GoogleUser $googleUser);

    /**
     * Log the user out of the application.
     *
     * @param \Modules\User\Models\User  $user
     * @return void
     */
    public function logout(User $user);
}