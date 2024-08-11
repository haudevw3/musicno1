<?php

use Foundation\Support\Str;

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

if (! function_exists('convertToDuration')) {
    function convertToDuration($time) {
        list($minutes, $seconds) = explode(':', $time);
        $duration = ($minutes * 60) + $seconds;
        return $duration;
    }
}

if (! function_exists('convertSecondsToTime')) {
    function convertSecondsToTime($seconds) {
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;
        
        if ($minutes < 60) {
            return sprintf("%02d phút %02d giây", $minutes, $remainingSeconds);
        } else {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            return sprintf("%02d giờ %02d phút", $hours, $remainingMinutes);
        }
    }
}

if (! function_exists('routeHasQueryString')) {
    function routeHasQueryString($name, array $params, array $queryStrings = []) {
        $url = route($name, $params);
        if (empty($queryStrings)) {
            return $url;
        }
        $path = '';
        $isFirst = true;
        foreach ($queryStrings as $key => $value) {
            if ($isFirst) {
                $isFirst = false;
                $path = "?$key=$value";
            } else {
                $path .= "&$key=$value";
            }
        }
        return rtrim($url, '/')."/$path";
    }
}