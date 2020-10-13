<?php
/**
 * Created by PhpStorm
 * User: pl
 * Date: 2020/10/13
 * Time: 13:52.
 */

namespace app;

/**
 * 日志db类 封装的一个查询日志的查询规则类
 * Class SearchDb.
 */
class SearchDb
{
    /**
     * log目录.
     *
     * @var string
     */
    private $logUrl;
    private $logFile;
    private $http = [];

    public function __construct()
    {
        $this->logUrl = __DIR__.'/log';
        $this->logFile = __DIR__.'/log/%s/%s_send_mail.log';
        $this->http = ['status' => 500, 'err_msg' => 'success', 'data' => []];
    }

    /**
     * 日志查询规则.
     *
     * @param $startTime
     * @param $endTime
     *
     * @return false|string
     */
    public function queryLog($startTime, $endTime)
    {
        $json_data = [];

        $startTime = date('Ym', strtotime($startTime));
        $endTime = date('Ym', strtotime($endTime));

        $startTime_m = date('m', strtotime($startTime));
        $endTime_m = date('m', strtotime($endTime));

        $startTime_day = date('d', strtotime($startTime));
        $endTime_day = date('d', strtotime($endTime));

        if (intval($startTime) != intval($endTime)) {
            $startTime_y = date('Y', strtotime($startTime));
            $endTime_y = date('Y', strtotime($endTime));
            //同一年
            if ($startTime_y == $endTime_y) {
                for ($i = $startTime_m; $i <= $endTime_m; $i++) {
                    $file_url = $this->logUrl.'/'.$startTime_y.$i;

                    if (file_exists($file_url)) {
                        $files = $this->getFile($file_url);

                        foreach ($files as $json_file) {
                            $json = file_get_contents($json_file);
                            $json_data = array_merge(json_decode($json, true), $json_data);
                        }
                    }
                }
            } else {
                //不同年份查询
            }
            $this->http['data'] = $json_data;
        } else {
            //同一个月的数据
            if (!file_exists(__DIR__.'/log/'.$startTime)) {
                return json_encode($this->http);
            }
            for ($i = $startTime_day; $i <= $endTime_day; $i++) {
                $json_file = sprintf($this->logFile, $startTime, $i);
                if (file_exists($json_file)) {
                    $json = file_get_contents($json_file);
                    $json_data = array_merge(json_decode($json, true), $json_data);
                }
            }
            $this->http['data'] = $json_data;
        }

        return json_encode($this->http);
    }

    /**
     * 默认今日数据.
     *
     * @return array
     */
    public function defaule()
    {
        $json_file = sprintf($this->logFile, date('Ym'), date('d'));
        if (file_exists($json_file)) {
            $json = file_get_contents($json_file);
            $this->http['data'] = json_decode($json, true);
        }

        return json_encode($this->http);
    }

    /**
     * 获取指定目录文件.
     *
     * @param $dir
     *
     * @return array
     */
    protected function getFile($dir)
    {
        $files = [];

        if (!is_dir($dir)) {
            return $files;
        }

        $handle = opendir($dir);

        if ($handle) {
            while (($fl = readdir($handle)) !== false) {
                $temp = $dir.DIRECTORY_SEPARATOR.$fl;
                //如果不加  $fl!='.' && $fl != '..'  则会造成把$dir的父级目录也读取出来
                if (is_dir($temp) && $fl != '.' && $fl != '..') {
                    $files[] = $temp;
                    $this->getFile($temp);
                } else {
                    if ($fl != '.' && $fl != '..') {
                        $files[] = $temp;
                    }
                }
            }
        }

        return $files;
    }
}
