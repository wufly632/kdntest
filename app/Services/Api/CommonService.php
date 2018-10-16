<?php
// +----------------------------------------------------------------------
// | CommonService.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2018/10/16 下午2:18
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Api;

class CommonService
{
    /**
     * 上传图片到AWS或者本地
     * @param string $file 上传文件类型
     * @param string $bucket 上传到亚马逊的空间别名
     * @param string $directory 本地临时目录
     * @param bool $aws 是否上传到aws
     * @param bool $keep_original_name 是否保持原始名称
     * @param bool $use_timestamp
     * @param string $contentType
     * @return mixed
     */
    public function uploadFile($file = "file", $bucket = 'cucoe', $directory = "uploads", $ali = true, $keep_original_name = false, $use_timestamp = false, $contentType = 'image/jpeg')
    {
        if ($ali) {
            $file = \request()->file($file);
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid(). '.' .$extension;
            return StorageHandler::uploadToAliOss( $file->getRealPath(), $directory.'/'.$fileName, $bucket);
        } else {
            return StorageHandler::uploadToLocal($file, $directory, $keep_original_name, null);
        }
    }
}
