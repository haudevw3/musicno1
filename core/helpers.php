<?php

if (! function_exists('random_avatar')) {
    function random_avatar() {
        $avatar = [
            asset('images/avatar/profile-1.png'),
            asset('images/avatar/profile-2.png'),
            asset('images/avatar/profile-3.png'),
            asset('images/avatar/profile-4.png'),
            asset('images/avatar/profile-5.png')
        ];
        $i = array_rand($avatar, 1);
        return $avatar[$i];
    }
}