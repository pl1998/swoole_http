<?php

namespace app;

require_once 'Log.php';
require_once APP_DIR.'/helpers.php';

/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 10:26.
 */
class ServiceQueue
{
    protected $server;

    public function __construct()
    {
        $config = require APP_CONFIG.'/server.php';
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
     *
     * @param $server
     * @param $fd
     * @param $from_id
     * @param $data
     */
    public function onTask($server, $fd, $from_id, $data)
    {
        $log = new Log();
        $data = json_decode($data, true);

        $log_data = $log->read();

        $new_data = [];
        $log_data = array_reverse($log_data);

        foreach ($log_data as $value) {
            if ($data['email'] == $value['email'] || $data['api_url'] == $value['api_url']) {
                $new_data = $value;
                continue;
            }
        }
        $log->write($data);
        //数据不存在就为发送一条邮件
        if (empty($new_data)) {
            send_email($data['content'], $data['email']);
        } else {
            $time_out = strtotime($new_data['read_time']) + $data['time'];

            // 当数据为不在时间范围类则触发邮件
            if (strtotime('now') > $time_out) {
                send_email($data['content'], $data['email']);
            }
        }
    }

    public function onFinish($server, $task_id, $data)
    {
        echo date('Y-m-d H:i:s');
    }
}
