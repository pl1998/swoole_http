<?php
declare(strict_types=1);
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/22
 * Time: 17:13
 */

namespace app;

use Swoole\Http\Server;

/**
 * Class HttpServer
 * @package app
 */
class HttpServer
{
    /**
     * @var Server
     */
    protected $server;

    protected $config=[];

    /**
     * 初始化加载配置并实例话HTTP服务类
     * HttpServer constructor.
     */
    public function __construct()
    {
        //获取服务端配置
        $config = config('server');
        $config = $config['http'];
        $this->server = new Server($config['host'],$config['port']);
    }
    /**
     * 监听HTTP请求并响应
     * @return $this
     */
    public function httpRequest()
    {
        $this->server->on('request',function ($request, $response){
            //执行路由单例分发HTTP请求到控制器
            if($request->server['request_uri']!='/favicon.ico'){
                $cache = memory_get_usage();
                echo "当前使用内存:".$cache."\n";
            }
             Route::init()->checkRoute($request,$response);
        });
        return $this;
    }
    /**
     * 启动Http服务
     */
    public function start()
    {
        $this->server->start();
    }
}
