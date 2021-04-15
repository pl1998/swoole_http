<?php
declare(strict_types=1);
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 3:41 下午
 **/

namespace app;


class Route
{
    /**
     * 路由树
     * @var array
     */
    private  array   $routeTree ;
    public   object  $request;
    public   object  $response;

    /**
     * 单例对象
     * @var object
     */
    private static $route;

    private function __construct()
    {
        echo "加载路由单例"."\n";
        $this->routeTree = config('route');

    }

    public static function init()
    {
        if(is_null(static::$route)) {
            static::$route = new self();
        }
        return self::$route;
    }

    /**
     * 检查路由并执行分发方法 功能较简陋
     * @param object $request
     * @param object $response
     * @return $this
     */
    public function checkRoute(object $request,object $response)
    {
        $url    = $request->server['request_uri'];
        $method = $request->server['request_method'];
        if(!array_key_exists($url,$this->routeTree[$method])) {
            $response->header('Content-Type', 'text/html');
            $response->end(view('404'));
        }else{
            if($url=='/favicon.ico'){
                $response->header('Content-Type', 'keep-alive');
                $response->end(__DIR__.'/static/favicon.ico');
            }else{
                $router = $this->routeTree[$method][$url];
                $class_name = $router[0];
                $func_name = $router[1];
                $this->request  = $request;
                $this->response = $response;
                $this->distributionRouter($class_name,$func_name);
            }
        }
    }

    /**
     * 路由分发到控制器
     * @param $class_name
     * @param $func_name
     */
    public function distributionRouter($class_name,$func_name)
    {
        $class_name->$func_name($this->request,$this->response);
    }

}
