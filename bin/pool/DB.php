<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 12:08 下午
 **/

namespace app\pool;


trait DB
{
    /**
     * 将数组转化为sql
     * @param $array
     * @param string $type
     * @param array $exclude
     * @return string
     */
    protected  function arrayToSql($array, $type='insert', $exclude = array())
    {
        $sql = '';
        if(count($array) > 0){
            foreach ($exclude as $exkey) {
                unset($array[$exkey]);
            }
            if('insert' == $type){
                $keys = array_keys($array);
                $values = array_values($array);
                $col = implode("`, `", $keys);
                $val = implode("', '", $values);
                $sql = "(`$col`) values('$val')";
                $sql = sprintf("INSERT INTO `%s`",$this->tables).$sql;
            }else if('update' == $type){
                $temparr = array();
                foreach ($array as $key => $value) {
                    $tempsql = "'$key' = '$value'";
                    $temparr[] = $tempsql;
                }
                $sql = implode(",", $temparr);
                $sql = sprintf("update `%s`",$this->tables).$sql;
            }
        }
        return $sql;
    }
}
