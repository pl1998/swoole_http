<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 10:59 上午
 **/

namespace app\pool;


use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool;

class PDO implements Pool
{
    private static $instance;

    protected $pool;

    public function __construct(array $config)
    {
        $this->pool = new PDOPool((new PDOConfig())
            ->withHost($config['host'])
            ->withPort($config['port'])
            ->withDbName($config['dbname'])
            ->withCharset($config['coding'])
            ->withUsername($config['username'])
            ->withPassword($config['password'])
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
     * 启动连接
     * @return \PDO|\Swoole\Database\PDOProxy
     */
    public function conn()
    {
        return $this->pool->get();
    }

    /**
     * 归还连接
     * @param object $pdo
     */
    public function close(object $pdo)
    {
        return $this->pool->put($pdo);
    }

}
