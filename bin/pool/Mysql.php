<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 9:24 上午
 **/

namespace app\pool;


interface Mysql
{
    //启动池子
    public function conn();

    public function get();

    public function put(object $pdo);

    public function fill();

    public function close(object $pdo);

    public function prepare(string $sql);
}
