<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/10/12
 * Time: 10:34
 */
if(version_compare(PHP_VERSION,'7.3.0', '<')){
    echo '当前版本为'.phpversion().'小于7.3.0';exit();
}
require 'vendor/autoload.php';
define('APP_PAHT',  __DIR__);

use app\HttpServer;
$http   = new HttpServer();
$server = config('server');
$url    = $server['http']['host'].':'.$server['http']['port'];
echo $url."\n";
$http->httpRequest()->start();










