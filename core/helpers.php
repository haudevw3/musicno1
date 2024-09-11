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

if (! function_exists('filterStr')) {
    function filterStr($str) {
        $str = strip_tags($str);
        $str = html_entity_decode($str);
        $str = preg_replace('/ +/', ' ', $str);
        $str = mb_strimwidth($str, 0, 1000);
        return trim($str);
    }
}

if (! function_exists('filterName')) {
    function filterName($str) {
        $str = filterStr($str);
        $unicode = [
            'a' => 'A', 'á' => 'Á', 'à' => 'À', 'ả' => 'Ả', 'ã' => 'Ã',
            'ạ' => 'Ạ', 'â' => 'Â', 'ă' => 'Ă', 'ắ' => 'Ắ', 'ặ' => 'Ặ',
            'ằ' => 'Ằ', 'ẳ' => 'Ẳ', 'ẵ' => 'Ẵ', 'ấ' => 'Ấ', 'ầ' => 'Ầ',
            'ẩ' => 'Ẩ', 'ẫ' => 'Ẫ', 'ậ' => 'Ậ',
            'b' => 'B',
            'c' => 'C',
            'd' => 'D', 'đ' => 'Đ',
            'e' => 'E', 'é' => 'É', 'è' => 'È', 'ẻ' => 'Ẻ', 'ẽ' => 'Ẽ',
            'ẹ' => 'Ẹ', 'ê' => 'Ê', 'ế' => 'Ế', 'ề' => 'Ề', 'ể' => 'Ể',
            'ễ' => 'Ễ', 'ệ' => 'Ệ',
            'f' => 'F',
            'g' => 'G',
            'h' => 'H',
            'i' => 'I', 'í' => 'Í', 'ì' => 'Ì', 'ỉ' => 'Ỉ', 'ĩ' => 'Ĩ',
            'ị' => 'Ị',
            'j' => 'J',
            'k' => 'K',
            'l' => 'L',
            'm' => 'M',
            'n' => 'N',
            'o' => 'O', 'ó' => 'Ó', 'ò' => 'Ò', 'ỏ' => 'Ỏ', 'õ' => 'Õ',
            'ọ' => 'Ọ', 'ơ' => 'Ơ', 'ô' => 'Ô', 'ố' => 'Ố', 'ồ' => 'Ồ',
            'ổ' => 'Ổ', 'ỗ' => 'Ỗ', 'ộ' => 'Ộ', 'ớ' => 'Ớ', 'ờ' => 'Ờ',
            'ở' => 'Ở', 'ỡ' => 'Ỡ', 'ợ' => 'Ợ',
            'p' => 'P',
            'q' => 'Q',
            'r' => 'R',
            's' => 'S',
            't' => 'T',
            'u' => 'U', 'ú' => 'Ú', 'ù' => 'Ù', 'ủ' => 'Ủ', 'ũ' => 'Ũ',
            'ụ' => 'Ụ', 'ư' => 'Ư', 'ứ' => 'Ứ', 'ừ' => 'Ừ', 'ử' => 'Ử',
            'ữ' => 'Ữ', 'ự' => 'Ự',
            'v' => 'V',
            'w' => 'W',
            'x' => 'X',
            'y' => 'Y', 'ý' => 'Ý', 'ỳ' => 'Ỳ', 'ỷ' => 'Ỷ', 'ỹ' => 'Ỹ',
            'ỵ' => 'Ỵ',
            'z' => 'Z',
        ];
        $result = [];
        $segments = explode(' ', $str);
        foreach ($segments as $segment) {
            $replacement = '';
            $segment = mb_strtolower($segment);
            $char = mb_str_split($segment)[0];
            if (array_key_exists($char, $unicode)) {
                $replacement = $unicode[$char];
            }
            $result[] = preg_replace("/$char/", $replacement, $segment, 1);
        }
        $result = implode(' ', $result);
        return $result;
    }
}