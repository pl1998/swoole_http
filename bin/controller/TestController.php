<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 2:20 下午
 **/

namespace app\controller;

use app\pool\DbPool;
use app\pool\RedisPool;

class TestController
{

    //每个控制器都应该有的单例
    protected static $init;

    public static function init()
    {
        if(is_null(static::$init)) {
            echo "加载Test控制器单例"."\n";
            static::$init = new self();
        }
        return static::$init;
    }

    public function test(object $request,object $response)
    {
        //业务逻辑
        $db = new DbPool();

        $id = $db->table('users')->insert([
            'name'=>'latent',
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

    public function testRedis(object $request,object $response)
    {
        $db = new RedisPool();
        $data = $db->get('_database_diag_active_0');
        $response->end(success($data));
    }
}
