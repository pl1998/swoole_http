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
    public function conn();

    public function close(object $pdo);
}
