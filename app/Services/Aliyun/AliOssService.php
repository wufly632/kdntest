<?php

namespace App\Services\Aliyun;


use Illuminate\Log\Logger;
use OSS\Core\OssException;
use OSS\OssClient;

class AliOssService
{
    public static function uploadToAliOss($filePath, $folder, $bucket)
    {
        $ossClint = self::getOssClint();
        try{
            $result = $ossClint->uploadFile($bucket, $folder, $filePath);
        }catch (OssException $exception){
            $logger = new Logger('aliyun-upload');
            $logger->info($exception->getMessage());
            return false;
        }
        return $result;
    }

    private static function getOssClint()
    {
        return new OssClient(env('OSS_ACCESS_ID', ''), env('OSS_ACCESS_SECRET', ''), env('SOO_ENDPOINT', ''));
    }
}