<?php
declare(strict_types=1);
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 5:59 下午
 **/
namespace app\pool;

use Swoole\Coroutine;
use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool;
use Swoole\Database\MysqliConfig;
use Swoole\Database\MysqliPool;
use Swoole\Runtime;

/**
 * Class DbPool
 * @package app\pool
 */
class DbPool implements Mysql
{
    private static $db;
    private array  $config;
    public $pool;

    private function __construct()
    {
        echo "加载数据库单例\n";
        $this->config = config('database.mysql');
        //一键协程开启异步io
        if(is_object($this->pool)) {
            $this->pool = $this->conn();
        }
        return $this;
    }
    public static function init()
    {
        static::$db = new self();
        if(is_null(static::$db)) {
            echo "加载数据库链接池单例\n";

        }
        return new self();
    }
    /**
     * 启动mysql连接池
     * @return mixed
     */
    public function conn()
    {
        if(in_array('PDO',get_loaded_extensions())){
            Runtime::enableCoroutine();
            return Coroutine\run(function () {
                $pool = new PDOPool((new PDOConfig())
                    ->withHost($this->config['host'])
                    ->withPort($this->config['port'])
                    ->withDbName($this->config['dbname'])
                    ->withCharset($this->config['coding'])
                    ->withUsername($this->config['username'])
                    ->withPassword($this->config['password'])
                ,$this->config['size']);
                return $pool;
            });
        }
        if(in_array('mysqli',get_loaded_extensions())){
            Runtime::enableCoroutine();
            return Coroutine\run(function () {
                $pool = new MysqliPool((new MysqliConfig())
                    ->withHost($this->config['host'])
                    ->withPort($this->config['port'])
                    ->withDbName($this->config['dbname'])
                    ->withCharset($this->config['coding'])
                    ->withUsername($this->config['username'])
                    ->withPassword($this->config['password'])
                ,$this->config['size']);
                return $pool;
            });
        }
        throw new \RuntimeException('请检查mysql连接扩展');
    }

    /**
     * 获取连接
     * @return mixed
     */
    public function get()
    {
       return $this->pool->get();
    }

    /**
     * 归还连接
     * @param object $pdo
     * @return mixed
     */
    public function put(object $pdo)
    {
        return $this->pool->put($pdo);
    }

    /**
     * t填充连接池
     * @return mixed
     */
    public function fill()
    {
        return $this->pool->fill();
    }

    /**
     * 关闭连接
     * @param object $pdo
     * @return mixed
     */
    public function close(object $pdo)
    {
        return $this->pool->close($pdo);
    }

    /**
     * 执行查询语句
     * @param string $sql
     * @return mixed
     */
    public function prepare(string $sql)
    {
        return $this->pool->prepare($sql);
    }
}
