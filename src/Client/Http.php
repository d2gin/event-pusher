<?php

namespace icy8\EventPusher\Client;
class Http
{
    protected $handler;
    protected $response;
    protected $responseInfo = [];
    protected $option       = [
        CURLOPT_RETURNTRANSFER => true,
    ];
    protected $headers      = [];

    public function __construct($url = "")
    {
        if ($url) $this->option[CURLOPT_URL] = $url;
    }

    /**
     * 设置为post请求
     * 默认get
     * @param array $data
     * @return $this
     */
    public function post($data = [])
    {
        $this->option[CURLOPT_POST] = 1;
        // 如果是数组，请求会变得很慢
        $this->option[CURLOPT_POSTFIELDS] = is_array($data) ? http_build_query($data) : $data;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function raw($data)
    {
        $this->headers['Content-Type']    = 'text/plain';
        $this->option[CURLOPT_POSTFIELDS] = is_array($data) ? json_encode($data) : $data;
        return $this;
    }

    /**
     * 发送请求
     * @param string $url
     * @return $this
     * @throws \Exception
     */
    public function send($url = '')
    {
        $this->handler = curl_init();
        if ($url) $this->option[CURLOPT_URL] = $url;
        if (!$this->option[CURLOPT_URL]) {
            throw new \Exception("Lost option CURLOPT_URL");
        }
        $this->option[CURLOPT_HTTPHEADER] = array_map(function ($v, $k) {
            return $k . ': ' . $v;
        }, array_values($this->headers), array_keys($this->headers));
        curl_setopt_array($this->handler, $this->option);
        $this->response     = curl_exec($this->handler);
        $this->responseInfo = curl_getinfo($this->handler);
        curl_close($this->handler);
        $this->reset();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse($format = '')
    {
        $res            = $this->response;
        $this->response = null;
        switch (strtolower($format)) {
            case "json":
                $data = json_decode($res, true);
                return $data !== null ? $data : false;
                break;
            default:
                return $res;
        }
    }

    /**
     * @return mixed
     */
    public function getResponseInfo($key = '')
    {
        if (!$key) return $this->responseInfo;
        return $this->responseInfo[$key] ?: '';
    }

    protected function reset()
    {
        $this->handler = null;
        $this->option  = [
            CURLOPT_RETURNTRANSFER => true,
        ];
        $this->headers = [];
    }
}