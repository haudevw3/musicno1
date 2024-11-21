<?php

use Illuminate\Support\Str;

if (! function_exists('date_on')) {
    /**
     * Get the current date by format "day-month-year".
     *
     * @return string
     */
    function date_on() {
        return date('d-m-Y');
    }
}

if (! function_exists('date_at')) {
    /**
     * Get the current date by format "day-month-year" and the timestamp.
     *
     * @return string
     */
    function date_at() {
        return date('d-m-Y H:i:s');
    }
}

if (! function_exists('format_timestamp')) {
    /**
     * Format timestamp with the given arguments.
     *
     * @param  int                $timestamp
     * @param  string|array|null  $keys
     * @return string
     */
    function format_timestamp($timestamp, $keys = null)
    {
        $hours = intval($timestamp / 3600);

        $minutes = intval(($timestamp - $hours * 3600) / 60);

        $seconds = $timestamp - ($hours * 3600) - ($minutes * 60);

        if ($hours >= 10) {
            $array['hours'] = "{$hours} giờ";
        } elseif ($hours > 0) {
            $array['hours'] = "0{$hours} giờ";
        }

        if ($minutes >= 10) {
            $array['minutes'] = "{$minutes} phút";
        } elseif ($minutes > 0) {
            $array['minutes'] = "0{$minutes} phút";
        }

        if ($seconds >= 10) {
            $array['seconds'] = "{$seconds} giây";
        } elseif ($seconds > 0) {
            $array['seconds'] = "0{$seconds} giây";
        }

        if (is_null($keys)) {
            return implode(' ', $array);
        }

        $keys = is_array($keys) ? $keys : [$keys];

        foreach ($keys as $as => $key) {
            if (isset($array[$key])) {
                $keys[$as] = $array[$key];
            } else {
                unset($keys[$as]);
            }
        }

        return implode(' ', $keys);
    }
}

if (! function_exists('isset_if')) {
    /**
     * Determine if and get the value with the given arguments.
     *
     * @param  mixed   $variable
     * @param  mixed   $callable
     * @param  mixed   $default
     * @return mixed
     */
    function isset_if(&$variable, $callable = null, $default = null)
    {
        if (! isset($variable)) {
            return $default;
        }

        if (is_null($callable)) {
            return $variable;
        }
        
        if (is_callable($callable)) {
            return $callable($variable);
        }

        return $callable;
    }
}

if (! function_exists('empty_if')) {
    /**
     * Determine if and get the value with the given arguments.
     *
     * @param  mixed  $variable
     * @param  mixed  $default
     * @param  mixed  $callable
     * @return mixed
     */
    function empty_if(&$variable, $default = null, $callable = null)
    {
        if (empty($variable)) {
            return $default;
        }

        if (is_null($callable)) {
            return $variable;
        }
        
        if (is_callable($callable)) {
            return $callable($variable);
        }

        return $callable;
    }
}

if (! function_exists('compare_if')) {
    /**
     * Compare if this value equals that value.
     *
     * @param  mixed  $needle
     * @param  mixed  $haystack
     * @param  mixed  $default
     * @param  mixed  $callable
     * @return mixed
     */
    function compare_if(&$needle, $haystack, $default = false, $callable = true)
    {
        if ($needle !== $haystack) {
            return $default;
        }
        
        if (is_callable($callable)) {
            return $callable($needle, $haystack);
        }

        return $callable;
    }
}

if (! function_exists('regex')) {
    /**
     * Get regex with the given key.
     *
     * @param  string  $key
     * @return string
     */
    function regex(string $key) {
        if ($key === 'page') {
            $result = 'page-[1-9][0-9]*';
        } elseif ($key === 'date_on') {
            $result = '/'.date_on().'/';
        }

        return $result;
    }
}

if (! function_exists('class_name')) {
    /**
     * Get the class name with the given value.
     *
     * @param  string  $value
     * @return string
     */
    function class_name(string $value)
    {   
        if ($pos = strrpos($value, '\\')) {
            return substr($value, $pos + 1);
        }

        return $value;
    }
}

if (! function_exists('badge')) {
    /**
     * Create an HTML badge with the given arguments.
     *
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    function badge(string $key, string $value) {
        $types = [
            'red' => 'bg-red-soft text-red',
            'orange' => 'bg-orange-soft text-orange',
            'yellow' => 'bg-yellow-soft text-yellow',
            'green' => 'bg-green-soft text-green',
            'teal' => 'bg-teal-soft text-teal',
            'cyan' => 'bg-cyan-soft text-cyan',
            'blue' => 'bg-blue-soft text-blue',
            'indigo' => 'bg-indigo-soft text-indigo',
            'purple' => 'bg-purple-soft text-purple',
            'pink' => 'bg-pink-soft text-pink',
        ];

        $html = "<span class='badge $types[$key]'>$value</span>";

        return $html;
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
     * @return mixed
     */
    function str_random($type = 'string', $length = 22)
    {
        if ($type === 'int') {
            $result = rand(10000, 99999);
        } elseif ($type === 'string') {
            $result = Str::random($length);
        }

        return $result;
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