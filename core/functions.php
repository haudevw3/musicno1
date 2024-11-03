<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if (! function_exists('menu')) {
    /**
     * Get a menu from the config with the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    function menu(string $key)
    {
        return config("menu.$key");
    }
}

if (! function_exists('label')) {
    /**
     * Get a label from the config with the given key.
     *
     * @param  string  $key
     * @return mixed
     */
    function label(string $key)
    {
        return config("label.$key");
    }
}

if (! function_exists('current_date')) {
    /**
     * Get the current date.
     *
     * @param  string|null  $format
     * @param  int|null     $timestamp
     * @return string
     */
    function current_date($format = null, $timestamp = null)
    {
        return date($format ?? 'Y-m-d H:i:s', $timestamp);
    }
}

if (! function_exists('typecast')) {
    /**
     * Get typecast with the given value.
     *
     * @param  mixed   $value
     * @param  string  $type
     * @return mixed
     */
    function typecast($value, $type = 'bool')
    {
        if ($type === 'bool') {
            $result = ($value === 'true') ? true : false;
        }

        return $result;
    }
}

if (! function_exists('random_avatar')) {
    /**
     * Get an avatar with the given value.
     *
     * @param  int     $value
     * @return string
     */
    function random_avatar(int $value)
    {
        $value = intval($value / 10000);

        if ($value == 0) {
            return asset('images/avatar/profile-1.png');
        } elseif ($value % 2 == 0) {
            return asset('images/avatar/profile-2.png');
        } elseif ($value % 3 == 0) {
            return asset('images/avatar/profile-3.png');
        } elseif ($value % 4 == 0) {
            return asset('images/avatar/profile-4.png');
        } elseif ($value % 5 == 0) {
            return asset('images/avatar/profile-5.png');
        } else {
            return asset('images/avatar/profile-6.png');
        }
    }
}

if (! function_exists('str_random')) {
    /**
     * Get a unique identifier string or integer with the given type.
     * 
     * @param  string  $type
     * @param  int     $length
     * @return string
     */
    function str_random($type = 'string', $length = 22)
    {
        $rand = rand(10000, 99999);

        if ($type != 'string') {
            return $rand;
        }

        return Str::random($length).strval($rand);
    }
}

if (! function_exists('str_filter')) {
    /**
     * Filter string with the given value.
     *
     * @param  string  $value
     * @return string
     */
    function str_filter(string $value)
    {
        $value = strip_tags($value);
        $value = html_entity_decode($value);
        $value = preg_replace('/ +/', ' ', $value);
        $value = mb_strimwidth($value, 0, 10000);
        return trim($value);
    }
}

if (! function_exists('str_ucwords')) {
    /**
     * Convert the first character of each word to uppercase.
     *
     * @param  string  $value
     * @return mixed
     */
    function str_ucwords(string $value) {
        $words = [];
        
        $value = mb_strtolower(str_filter($value));
        
        $segments = explode(' ', $value);
        foreach ($segments as $segment) {
            $words[] = mb_ucfirst($segment, 'UTF-8');
        }
        
        return implode(' ', $words);
    }
}

if (! function_exists('template_email')) {
    /**
     * Render string HTML to send mail.
     *
     * @param  string  $subject
     * @param  string  $content
     * @param  array   $options
     * @return string
     */
    function template_email(string $subject, string $content, array $options = [])
    {
        $url = $options['url'];
        $name = $options['name'];
        $token = $options['token'];
        $btnName = $options['btn_name'];

        $html = <<<EOD
            <!doctype html>
            <html lang="vi">
            <head>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                <title>MusicNo1 - {$subject}</title>
                <meta name="description" content="{$subject}">
            </head>
            <body style="margin:0;padding:0;background-color:#ffffff">
                <center>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid#dadce0;border-radius:8px;max-width:500px;margin-top:50px;padding-left:20px;padding-right:20px;">
                        <tbody>
                            <tr>
                                <th style="height:100px">
                                    <h1 style="margin:0;margin-bottom:10px;padding:0;color:#4b4b4b;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:700;line-height:1.2;text-align:center;word-wrap:normal">MusicNo1</h1>
                                    <p style="margin:0;margin-bottom:10px;padding:0;color:#4b4b4b;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;line-height:26px;text-align:center;word-wrap:normal">{$subject}</p>
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    <table align="center" style="border-top:1px solid#dadce0;border-top:2px solid #dadce0;padding-top:20px;">
                                        <tbody>
                                            <tr>
                                                <th style="max-height:200px;padding-bottom:20px;">
                                                    <p style="margin:0;padding:0;color:#4b4b4b;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:600;text-align:left;word-wrap:normal;">Xin chào {$name}!</p>
                                                    <p style="margin:0;margin-top:10px;padding:0;color:#4b4b4b;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;text-align:left;word-wrap:normal;">
                                                        {$content}{$token}
                                                    </p>
                                                    <a style="margin:0;margin-top:20px;padding:12px 24px;color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:500;text-decoration:none;
                                                    display:inline-block;background-color:#4184f3;border-radius:6px;min-width:90px;line-height:16px;word-wrap:normal;"
                                                    href="{$url}">{$btnName}</a>
                                                    <p style="margin:0;margin-top:20px;padding:0;color:#afafaf;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;text-align:center;word-wrap:normal;">
                                                        Chuyển hướng đến trang web tại đây
                                                    </p>
                                                    <a style="margin:0;padding:0;color:#4b4b4b;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;text-decoration:none;text-align:center;word-wrap:normal;"
                                                    href="">https://musicno1.online</a>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </body>
            </html>
        EOD;

        return $html;
    }
}