<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 5:26 下午
 **/

namespace app\controller;


use app\pool\DbPool;

class IndexController
{
    //每个控制器都应该有的单例
    protected static $init;

    public static function init()
    {
       if(is_null(static::$init)) {
           echo "加载控制器单例"."\n";
           static::$init = new self();
       }
       return static::$init;
    }

    /**
     * @param object $request
     * @param object $response
     */
    public function index(object $request,object $response)
    {
        //业务逻辑
        $db  = DbPool::init();
        $pdo = $db->get();
        $data = $pdo->prepare("select * from users");
        $db->put($pdo);
        $response->header('Content-Type','application/json');
        $response->end(success($data));
    }
}
