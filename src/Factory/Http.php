<?php

namespace icy8\EventPusher\Factory;

use icy8\EventPusher\Factory;
use \icy8\EventPusher\Client\Http as HttpEntry;

/**
 * @method static Http post($data = [])
 * @method static Http raw($data)
 * @method static Http send($url = '')
 * @method static Http getResponse($format = '')
 * @method static Http getResponseInfo($key = '')
 * Class Http
 * @package icy8\EventPusher\Factory
 */
class Http extends Factory
{
    protected static $name = "Http";

    public static function resolve()
    {
        return new HttpEntry();
    }
}