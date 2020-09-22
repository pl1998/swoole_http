<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 16:57.
 */
require 'vendor/autoload.php';

require_once __DIR__.'/helpers.php';
//定义一个日志目录常量
define('APP_DIR', __DIR__);
use app\ServiceQueue;

$serv = new ServiceQueue();
