## 基于swoole的日志系统，提供了简单便捷的Api

#### 功能简洁

  * http服务 、tcp服务、邮件异步发送、日志异步存储、简洁vue界面
  * 文件json式存储，提供简单的日期查询条件
  * 只需配置好配置文件 两行命令就能启动

#### 安装需求
  
   * 安装了swoole扩展

#### 如何启动？
```shell script

git clone https://github.com/pl1998/swoole_log.git

cd swoole_log

// 查看是否安装了swoole

php --ri swoole 

// 测试环境 laradock

// 启动http服务

php http.php

// 启动tcp服务

php tcp.php
```

#### 简单配置`config/server.php`服务端口

```php
return [
    /**
     * http服务
     */
    'http' => [
        'host' => '0.0.0.0',
        'port' => 9501
    ],
    /**
     * tcp服务
     */
    'tcp'  => [
        'host' => '127.0.0.1',
        'port' => 9502,
        'server' => [
            'task_worker_num' => 3,        //开启的进程数 一般为cup核数 1-4倍
            'daemonize'       => 0,             //已守护进程执行该程序   //0 为调试模式 1 为 守护进程模式
            'max_request'     => 10000,       //worker进程最大任务数
            'dispatch_mode'   => 2,         //设置为争抢模式
            'task_ipc_mode'   => 3,         //设置为消息队列模式
        ]
    ]
];

```

#### 简单配置`config/email.php`邮件端口

```php

return [
    'username'    => 'pltruenine@163.com',
    'password'    => 'xxxx',
    'host'        => 'smtp.163.com',
    'smtp_secure' => 'ssl',
    'port'        => 465,
    'setfrom'     => 'pltruenine@163.com',
];
```


#### 提供的api

#### 异步邮件发送、日志存储

`127.0.0.1/api/get_log`

##### 请求格式

`post`

##### 参数

| 参数   | 是否必选 | 备注      | 限制 | 新增 |
| ------| -------- | --------- | ---- | ---- |
| email|   必须   | 收件人邮箱   |      |      |
| time |   必须   | 发送间隔时间 时间戳 例如 一个小时 3600  |      |      |
| content|   必须   | 错误内容   |      |      |
| api_url|   必须   | 发送错误的接口名称  |      |      |



```json
{
    "status": 200,
    "err_msg": "success"
}
```

#### 日志页面访问 `http://127.0.0.1:9501/get_log`

