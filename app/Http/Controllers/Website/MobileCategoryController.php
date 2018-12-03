<?php

namespace App\Http\Controllers\Website;

use App\Services\Api\ApiResponse;
use App\Services\Website\MobileCategoryService;
use Illuminate\Support\Facades\DB;

class MobileCategoryController
{
    protected $mobileCategoryService;

    public function __construct(MobileCategoryService $mobileCategoryService)
    {
        $this->mobileCategoryService = $mobileCategoryService;
    }

    public function index()
    {
        $categorys = $this->mobileCategoryService->get();
        return view('website.mobile.category', compact('categorys'));
    }

    public function store()
    {
        $item = request()->input('item');
        try {
            DB::beginTransaction();
            $newItem = $this->mobileCategoryService->updateOrCreate($item);
            DB::commit();
            return ApiResponse::success($newItem);
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::failure(g_API_STATUS, '保存失败');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->mobileCategoryService->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return ApiResponse::failure(g_API_STATUS, '删除失败');
        }

    }
}