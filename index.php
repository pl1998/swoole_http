<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 11:22.
 */

use  app\Client;

require 'vendor/autoload.php';

require_once __DIR__.'/helpers.php';

//定义一个日志目录常量

$api = ['email', 'time', 'content', 'api_url'];

//邮件队列入口
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    throw new Exception('路由不存在', 404);
}
$params = $_POST;

//参数过滤
if (intended_effect(array_keys($params), $params)) {
    echo 'api 参数错误';
    exit;
}

$client = new Client($params);
$client->connect();
