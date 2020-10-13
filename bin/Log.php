<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/9/21
 * Time: 13:56.
 */

namespace app;

/**
 * 文件日志类
 * Class Log.
 */
class Log
{
    protected $fileUrl;
    protected $fileName;
    protected $log;

    public function __construct()
    {
        $this->log = __DIR__.'/log/'.date('Ym');

        $this->fileName = '/'.date('d').'_send_mail.log';

        if (!empty($this->log)) {
            $this->fileUrl = $this->log.$this->fileName;
        } else {
            $this->log = LOG;
            $this->fileUrl = LOG.$this->fileName;
        }
    }

    /**
     * 文件数据写入.
     */
    public function write($param)
    {
        if (!file_exists($this->log)) {
            mkdir($this->log);
            chmod($this->log, 0777);
        }
        if (!file_exists($this->log.$this->fileName)) {
            touch($this->log.$this->fileName);
            chmod($this->log.$this->fileName, 0777);
        }

        $data = $this->read();

        if (is_null($data)) {
            $data = [];
        }

        $param['read_time'] = date('Y-m-d H:i:s');

        $param = array_merge($data, [$param]);

        $json = json_encode($param, JSON_UNESCAPED_UNICODE);

        $file = fopen($this->fileUrl, 'w') or exit('文件不存在');

        fwrite($file, $json);
        fclose($file);

        return true;
    }

    /**
     * 读取文件.
     *
     * @return false|mixed|string
     */
    public function read()
    {
        $file_url = $this->log.'/'.$this->fileName;
        $fh = fopen($file_url, 'r');
        $data = fgets($fh);
        fclose($fh);
        $data = json_decode($data, true);

        return $data;
    }
}
