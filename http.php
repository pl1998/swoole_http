<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/10/12
 * Time: 10:34
 */
require 'vendor/autoload.php';
require_once __DIR__.'/helpers.php';

define('APP_DIR', __DIR__);
define('APP_ROUTE',__DIR__.'/route');
define('APP_CONFIG',__DIR__.'/config');

use app\HttpServer;

$http = new HttpServer();

echo "http服务启动成功--";

$http->httpRequest()->start();







