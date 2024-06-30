<?php

namespace Core\Service;

use Core\Util\Singleton;
use Foundation\Support\Facades\Auth;
use Google_Client;

class OAuthService extends Singleton
{
    protected $client;

    public function __construct()
    {
        $service = config('services.google');
        $client = new Google_Client;
        $client->setClientId($service['key']);
        $client->setClientSecret($service['secret']);
        $client->setRedirectUri($service['redirect']);
        $client->addScope('email');
        $client->addScope('profile');
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $this->client = $client;
    }

    public function url()
    {
        return $this->client->createAuthUrl();
    }

    public function oauth($code)
    {
        $data = $this->client->fetchAccessTokenWithAuthCode($code);
        $userInfo = json_decode(base64_decode(explode('.', $data['id_token'])[1]), true);
        $attributes = [
            'fullname' => $userInfo['name'],
            'username' => explode('@', $userInfo['email'])[0],
            'password' => $userInfo['at_hash'],
            'email' => $userInfo['email'],
            'role' => 2,
            'image' => $userInfo['picture'],
            // 'access_token' => $data['access_token'],
            // 'refresh_token' => $data['refresh_token'],

        ];
        $userService = app('Modules\User\Service\UserService');
        $user = $userService->findOne(['username' => $attributes['username']]);
        if (! $user) {
            $userService->create($attributes);
        } else {
            $userService->updateOne(
                $user['id'],['password' => password_hash($attributes['password'], PASSWORD_DEFAULT)]
            );
        }
        if (Auth::attempt($attributes, true)) {
            return redirect()->route('home');
        }
    }
}