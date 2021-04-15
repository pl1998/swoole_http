## 基于swoole的HTTP服务器

#### 目录结构
```shell script
├── README.md 
├── bin  
│   ├── Client.php
│   ├── HttpServer.php
│   ├── Log.php
│   ├── Route.php
│   ├── ServerQueue.php
│   ├── controller
│   │   ├── Controller.php
│   │   └── IndexController.php
│   ├── exception
│   │   └── HttpException.php
│   ├── pool
│   │   ├── DbPool.php
│   │   └── RedisPool.php
│   ├── queue
│   │   └── Queue.php
│   └── static
│       └── favicon.ico
├── composer.json
├── composer.lock
├── config
│   ├── database.php
│   ├── email.php
│   ├── log.php
│   ├── route.php
│   └── server.php
├── helpers.php           
├── http.php              
├── tcp.php           
├── test.php 
└── view 
    ├── 404.html
    ├── echarts.html
    └── log_list.html
```

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


php --ri swoole 

// 测试环境 laradock

// 启动http服务

php http.php

// 启动tcp服务

php tcp.php
```

#### 简单配置`config/server.php`服务端口



