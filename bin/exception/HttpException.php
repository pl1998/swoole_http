<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 6:06 下午
 **/

namespace app\exception;


use app\Log;
use Swoole\Coroutine;
use Swoole\Exception;
use Throwable;

class HttpException extends Exception
{
    /**
     * 继承基类 并通过日期驱动记录错误信息
     * HttpException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        throw new \RuntimeException($message, $code);

    }
}
