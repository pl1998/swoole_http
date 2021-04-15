<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 5:29 下午
 **/

namespace app\controller;


use Swoole\Exception;

class Controller
{
    public static function init()
    {
        $self = new self();
        return $self;
    }

    public function __call($method, $parameters)
    {
       throw new Exception('未找到该方法');

    }
}
