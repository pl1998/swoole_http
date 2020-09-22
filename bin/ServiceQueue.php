<?php

namespace app;

use PHPMailer\PHPMailer\PHPMailer;
require_once 'Log.php';
require_once APP_DIR.'/helpers.php';

/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 10:26
 */

class ServiceQueue
{
    protected $server;
    public function __construct()
    {
        $this->server = new \Swoole\Server('127.0.0.1',9502);

        $this->server->set([
            'task_worker_num' => 3,        //开启的进程数 一般为cup核数 1-4倍
            'daemonize' => 1,             //已守护进程执行该程序   //0 为调试模式 1 为 守护进程模式
            'max_request' => 10000,       //worker进程最大任务数
            'dispatch_mode' => 2,         //设置为争抢模式
            'task_ipc_mode' => 3,         //设置为消息队列模式
        ]);

        $this->server->on('Receive', array($this, 'onReceive'));
        $this->server->on('Task', array($this, 'onTask'));
        $this->server->on('Finish', array($this, 'onFinish'));
        $this->server->start();


    }

    public function onReceive(\swoole_server $server, $fd, $form_id,$data)
    {
        $this->server->task($data);
    }

    /**
     * 异步接口逻辑
     * @param $server
     * @param $fd
     * @param $from_id
     * @param $data
     */

    public function onTask($server, $fd, $from_id, $data)
    {

        $log = new Log();
        $data = json_decode($data,true);

        $log_data = $log->read();

        $new_data = [];
        $log_data = array_reverse($log_data);



        foreach ($log_data as $value) {
            if($data['email'] == $value['email'] || $data['api_url'] == $value['api_url']) {
                $new_data = $value;
                continue;
            }
        }

        $log->write($data);

        //数据不存在就为发送一条邮件
        if(empty($new_data)) {
            send_email($data['content'],$data['email']);
        } else {
            $time_out = strtotime($new_data['read_time'])+$data['time'];

            // 当数据为不在时间范围类则触发邮件
            if(strtotime('now')>$time_out) {
                send_email($data['content'],$data['email']);
            }
        }

    }
    public function onFinish($server, $task_id, $data)
    {
        echo date('Y-m-d H:i:s');
    }



}



