<?php
/**
 * Created by PhpStorm.
 * User: rogers
 * Date: 18-11-21
 * Time: 下午2:42
 */

namespace App\Http\Controllers\Website;


use App\Services\Api\ApiResponse;
use App\Services\Website\MobileHomeCardService;

class MobileCardController
{
    protected $mobileHomeCardService;

    public function __construct(MobileHomeCardService $mobileHomeCardService)
    {
        $this->mobileHomeCardService = $mobileHomeCardService;
    }

    public function store()
    {

    }

    public function update($id)
    {
        try {
            $this->mobileHomeCardService->update($id, request()->only('content'));
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, '修改失败');
        }
    }
}