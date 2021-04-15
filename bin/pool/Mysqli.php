<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 11:07 上午
 **/

namespace app\pool;


use Swoole\Database\MysqliConfig;
use Swoole\Database\MysqliPool;


class Mysqli implements Mysql
{
    private static $instance;

    protected $pool;

    public function __construct(array $config)
    {
        $this->pool = new MysqliPool((new MysqliConfig())
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

    public function conn()
    {
        return $this->pool->get();
    }

    public function close(object $pdo)
    {
        return $this->pool->put($pdo);
    }

}
