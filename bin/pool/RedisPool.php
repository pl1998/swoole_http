<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/14
 * Time : 11:53 上午
 **/

namespace app\pool;


use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool as RedisDb;

class RedisPool
{

    protected $pool;
    private $db;

    public function __construct()
    {
        if(in_array('PDO',get_loaded_extensions())){
            $config = config('database.redis');
            $this->pool = Redis::getInstance($config);
        }else{
            throw new \RuntimeException('请检查redis扩展');
        }
    }

    protected function getConn()
    {
       $this->db =  $this->pool->conn();
    }

    public function release(object $db)
    {
        $this->pool->close($db);
    }

    public function get(string $key)
    {
        $this->getConn();
        $data = $this->db->get($key);
        $this->release($this->db);
        return json_decode($data,true);
    }

}
