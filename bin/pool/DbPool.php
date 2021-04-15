<?php
declare(strict_types=1);
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 5:59 下午
 **/
namespace app\pool;


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

    public function getConn()
    {
       $this->db =  $this->pool->conn();
    }

    public function table(string $table)
    {
        $this->tables = $table;
        return $this;
    }

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

    public function release(object $db)
    {
        $this->pool->close($db);
        return true;
    }

}
