<?php

namespace app;
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 10:27
 */

class Client
{
    protected $client;

    protected $params;

    public function __construct($params)
    {
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);
        $this->params = $params;
    }

    /**
     * 连接客户端并并向服务端推送数据
     * @return false|string
     */
    public function connect()
    {
        /**
         * 客户端 服务端端口一致
         */
        if (!$this->client->connect('127.0.0.1', 9502, 1)) {
            return json_encode([
                'code' => 500,
                'err_msg' => '链接异步客户端失败'
            ]);
        }

        $this->client->send($this->params);
    }


}