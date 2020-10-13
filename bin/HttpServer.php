<?php
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

    /**
     * HttpServer constructor.
     */
    public function __construct()
    {
        $config = require APP_CONFIG.'/server.php';
        $config = $config['http'];

        $this->server = new Server($config['host'],$config['port']);
    }

    /**
     * 服务响应
     * @return $this
     */
    public function httpRequest()
    {
        $this->server->on('request',function ($request, $response){

            $url    = $request->server['request_uri'];

            $method = $request->server['request_method'];

            $route = require APP_ROUTE.'/api.php';

            if(!array_key_exists($method,$route)) {
                $response->header('Content-Type', 'text/html');
                $html = file_get_contents(__DIR__.'/view/404.html');
                $response->end($html);
            }
            //简单的路由控制

            switch ($url) {
                case '/favicon.ico':
                    //设置网址图标
                    $response->sendfile(__DIR__.'/static/favicon.ico');
                    break;
                case '/get_log':
                    $response->header('Content-Type', 'text/html');
                    $html = file_get_contents(__DIR__.'/view/log_list.html');
                    $response->end($html);
                    break;
                case '/api/get_log':
                    $response->header('Content-Type', 'application/json');
                    if($method == 'GET') {
                        $params = $request->get;
                        $db = new SearchDb();
                        if(!empty($params['startTime']) && !empty($params['endTime'])) {
                            $json_data = $db->queryLog($params['startTime'],$params['endTime']);
                        } else {
                            $json_data = $db->defaule();
                        }
                        $response->end($json_data);
                    } else {
                        $params = $request->post;
                        $client = new Client(json_encode($params,JSON_UNESCAPED_UNICODE));
                        $client->connect();
                        $response->header('Content-Type', 'application/json');
                        $response->end(json_encode(['status'=>200,'err_msg'=>'success']));
                    }
                    break;
            }
        });
        return $this;
    }


    /**
     * 启动服务
     */
    public function start()
    {
        $this->server->start();
    }

}