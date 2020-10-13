<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/10/13
 * Time: 11:21
 */
require 'vendor/autoload.php';

define('APP_DIR', __DIR__);
define('APP_CONFIG',__DIR__.'/config');

use app\ServerQueue;
echo "tcp服务启动成功--";
new ServerQueue();