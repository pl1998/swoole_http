<?php
declare(strict_types=1);
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
        $db = new DbPool();
        $id = $db->table('users')->insert([
            'name'=>'pl2',
            'password'=>'',
            'avatar'=>'',
            'email'=>'pltruenine@163.com',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'uid'=>'56895',
            'age'=>22,
        ]);
        $response->header('Content-Type','application/json');
        $response->end(success([
            'id'=>$id
        ],'插入成功'));
    }

    public function create(object $request,object $response)
    {
        $response->end(success([
            'id'=>3
        ],'插入成功'));
    }
}
