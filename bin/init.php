<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/15
 * Time : 9:22 上午
 **/

// mysql 连接池单例
class_alias('db',\app\pool\DbPool::init());
// redis 连接池单例
class_alias('redis',\app\pool\DbPool::init());

