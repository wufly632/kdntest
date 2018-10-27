<?php
/**
 * Created by PhpStorm.
 * User: longyuan
 * Date: 2018/10/27
 * Time: 5:38 PM
 */
namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Services\Aliyun\AliStsService;
use App\Services\Api\ApiResponse;

class AliyunController extends Controller
{
    public function getAliStsToken()
    {
        $result = AliStsService::getStsToken();
        if($result) return ApiResponse::success($result);
        return ApiResponse::failure(g_API_ERROR, '图片上传失败，稍后再试');
    }
}