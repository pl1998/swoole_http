<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 3:54 下午
 **/

namespace app\pool;


use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool;

class Redis implements Pool
{
    private static $instance;

    protected $redis;
    protected $db;

    public function __construct(array $config)
    {
        $this->redis = new RedisPool((new RedisConfig())
            ->withHost($config['host'])
            ->withPort($config['port'])
            ->withAuth($config['password'])
            ->withDbIndex($config['db'])
            ->withTimeout($config['timeout'])
            ,$config['size']);

    }

    public static function getInstance($config=[])
    {
        if(is_null(static::$instance)) {
            static::$instance = new self($config);
        }
        return static::$instance;
    }

    /**
     * 连接
     */
    public function conn()
    {
        $this->db =  $this->redis->get();

    }

    /**
     * 归还
     * @return bool
     */
    public function close(object $db)
    {
        $this->redis->put($db);

    }
}
