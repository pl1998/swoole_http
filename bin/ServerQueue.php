<?php

namespace app;

use app\queue\Queue;

/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 10:26.
 */
class ServerQueue
{
    protected $server;

    public function __construct()
    {
        $config = config('server');
        $config = $config['tcp'];
        $this->server = new \Swoole\Server($config['host'], $config['port']);

        $this->server->set($config['server']);

        $this->server->on('Receive', [$this, 'onReceive']);
        $this->server->on('Task', [$this, 'onTask']);
        $this->server->on('Finish', [$this, 'onFinish']);
        $this->server->start();
    }

    public function onReceive(\swoole_server $server, $fd, $form_id, $data)
    {
        $this->server->task($data);
    }

    /**
     * 异步接口逻辑.
     * @param $server
     * @param $fd
     * @param $from_id
     * @param $data
     */
    public function onTask($server, $fd, $from_id, $data)
    {

    }

    public function onFinish($server, $task_id, $data)
    {

    }
}
