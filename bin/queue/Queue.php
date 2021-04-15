<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 5:16 下午
 **/

namespace app\queue;


interface Queue
{
    //投递任务
    public function onReceive();
    //异步消费
    public function onTask();
    //结束
    public function onFinish();
}
