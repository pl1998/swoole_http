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

/**
 * Class DbPool
 * @package app\pool
 */
class DbPool
{
    use DB;
    protected $pool;
    private $db;
    protected $tables;
    protected $transaction_status = false;

    public function __construct()
    {
        $config = config('database.mysql');
        if(in_array('PDO',get_loaded_extensions())){
            $this->pool = PDO::getInstance($config);
        }elseif(in_array('mysqli',get_loaded_extensions())) {
            $this->pool = Mysqli::getInstance($config);
        }else{
            throw new \RuntimeException('请检查mysql扩展');
        }
    }

    /**
     * 去连接池拿实例
     */
    public function getConn()
    {
        if($this->transaction_status==false){
            $this->db =  $this->pool->conn();
        }
    }

    /**
     * 引入表
     * @param string $table
     * @return $this
     */
    public function table(string $table)
    {
        $this->tables = $table;
        return $this;
    }

    /**
     * 数据插入
     * @param array $array
     * @return int
     */
    public function insert(array $array) :int
    {
        $this->getConn();

        $query = $this->arrayToSql($array);

        $statement = $this->db->prepare($query);

        $statement->execute();

        $ret = (int) $this->db->lastInsertId();

        $this->release($this->db);

        return $ret;
    }

    /**
     * 开启事务
     */
    public function beginTransaction()
    {
        if($this->transaction_status){
            throw new \RuntimeException('事务嵌套');
        }
        $this->getConn();
        $this->db->beginTransaction();
        $this->transaction_status=true;
        //协程关闭之前(即协程函数执行完毕时) 进行调用
//        Coroutine::defer(function (){
//           if($this->transaction_status){
//               $this->rollBack();
//           }
//        });
    }

    /**
     * 事务执行
     */
    public function commit()
    {
        $this->getConn();
        $this->db->commit();
        $this->transaction_status = false;
        $this->release($this->db);
    }

    /**
     * 回退
     */
    public function rollBack()
    {
        $this->getConn();
        $this->db->rollBack();
        $this->transaction_status = false;
        $this->release($this->db);
    }


    /**
     * 执行sql查询
     * @param string $query
     * @return bool
     */
    public function query(string $query) :bool
    {
        $this->getConn();

        $statement = $this->db->prepare($query);

        $result = $statement->execute();

        $this->release($this->db);

        return $result;
    }

    /**
     * 归还连接
     * @param object $db
     * @return bool
     */
    public function release(object $db)
    {
        if($this->transaction_status==false){
            $this->pool->close($db);
            return true;
        }
        return  false;
    }
}
