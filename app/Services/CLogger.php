<?php
/**
 * Created by PhpStorm.
 * User: wufly
 * Date: 2018/9/18
 * Time: 上午0:50
 */
namespace App\Services;

use Illuminate\Support\Facades\Config;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class CLogger
{
    /**
     * 自定义日志文件
     *
     * @param $name
     * @param null $dir
     * @return Logger
     */
    public static function getLogger($name, $dir = null)
    {
        $logger = new Logger($name);
        $date = date('Ymd', time());
        $file_name = $name . '_' . $date . '.log';
        $log_path = Config::get('log')['log_path']; //与log配置里的log_path目录保持一致
        $path = $log_path .'/'. ($dir ? ($dir . '/') : '') . $file_name;
        $stream = new StreamHandler($path, Logger::INFO);
        $logger->pushHandler($stream);
        return $logger;
    }
}