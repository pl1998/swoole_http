<?php
/**
 * Created By PhpStorm.
 * User : Latent
 * Date : 2021/4/13
 * Time : 6:10 下午
 **/

namespace app;


class Log
{

    private static $log;

    public function __construct()
    {

    }
    public static function init()
    {
        if(is_null(static::$log)) {
            static::$log = new self();
        }
        return static::$log;

    }

    /**
     * 日志写入
     * @param string $msg
     * @param array $log
     */
    public function write(string $msg,array $log)
    {
        $file_path = APP_PAHT.'/log/'.date('Y_m_d').'.log';
        $file = fopen($file_path, "w");
        $text = date('Y-m-d H:i:s').':'.$msg.json_encode($log,JSON_UNESCAPED_UNICODE);
        fwrite($file,$text );
        fclose($file);
    }
}
