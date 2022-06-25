<?php

namespace icy8\EventPusher;
abstract class Factory
{
    protected static $name;
    protected static $instance = [];

    public static function __callStatic($name, $arguments)
    {
        if (!isset(static::$instance[static::$name])) {
            self::$instance[static::$name] = static::resolve();
        }
        return call_user_func_array([self::$instance[static::$name], $name], $arguments);
    }

    static abstract function resolve();
}