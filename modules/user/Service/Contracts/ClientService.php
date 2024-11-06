<?php

namespace Modules\User\Service\Contracts;

use Laravel\Socialite\Contracts\User as GoogleUser;
use Modules\User\Models\User;

interface ClientService
{
    /**
     * @param  array  $data
     * @return \Jenssegers\Mongodb\Eloquent\Model
     */
    public function create(array $data);

    // /**
    //  * @param  string  $id
    //  * @param  array   $data
    //  * @return bool
    //  */
    // public function updateOne($id, array $data);

    /**
     * Generate a token with the given expiration time if any.
     *
     * @param  array   $data
     * @return string
     */
    public function generateToken(array $data);
    
    /**
     * Resolve login for a client using the given credentials.
     *
     * @param  array  $credentials
     * @return \Core\Http\ResponseBag
     */
    public function login(array $credentials);

    /**
     * Resolve login for a client using the given Google account.
     *
     * @param  \Laravel\Socialite\Contracts\User  $googleUser
     * @return void
     */
    public function loginByGoogle(GoogleUser $googleUser);

    /**
     * Log the user out of the application.
     *
     * @param \Modules\User\Models\User  $user
     * @return void
     */
    public function logout(User $user);
}