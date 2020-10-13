<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/22
 * Time: 17:29.
 */

return [
    /**
     * http服务
     */
    'http' => [
        'host' => '0.0.0.0',
        'port' => 9501,
    ],
    /**
     * tcp服务
     */
    'tcp'  => [
        'host'   => '127.0.0.1',
        'port'   => 9502,
        'server' => [
            'task_worker_num' => 3,        //开启的进程数 一般为cup核数 1-4倍
            'daemonize'       => 0,             //已守护进程执行该程序   //0 为调试模式 1 为 守护进程模式
            'max_request'     => 10000,       //worker进程最大任务数
            'dispatch_mode'   => 2,         //设置为争抢模式
            'task_ipc_mode'   => 3,         //设置为消息队列模式
        ],
    ],
];
