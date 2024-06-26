<?php

namespace Core\Util;

class Singleton
{
    private static $instances = [];

    public static function getInstance()
    {
        $subClass = static::class;

        if (! isset(self::$instances[$subClass])) {
            self::$instances[$subClass] = new static;
        }

        return self::$instances[$subClass];
    }
}