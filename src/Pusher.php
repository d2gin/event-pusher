<?php

namespace icy8\EventPusher;

use icy8\EventPusher\Factory\Http;

class Pusher
{
    protected $host = '127.0.0.1';
    protected $port = '9580';

    public function __construct($host, $port = '')
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function scheme($host, $scheme = 'http')
    {
        if (preg_match('!^http[s]\://!i', $host)) {
            return $host;
        }
        return $scheme . '://' . $host;
    }

    public function trigger($name, $channel, $data)
    {
        $url    = $this->scheme($this->host) . ($this->port ? ':' . $this->port : '') . '/event';
        $client = Http::post([
            "event"   => $name,
            "channel" => $channel,
            "data"    => $data,
        ])->send($url);
        return $client->getResponse("json");
    }

    public function broadcast($name, $data)
    {
        $url    = $this->scheme($this->host) . ($this->port ? ':' . $this->port : '') . '/broadcast';
        $client = Http::post([
            "event" => $name,
            "data"  => $data,
        ])->send($url);
        return $client->getResponse("json");
    }
}
