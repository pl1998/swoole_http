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

try {
    new ServerQueue();
    echo "tcp启动成功~~~";
}catch (\Exception $exception){
    echo "Tcp ERROR---:".$exception->getMessage();
}

