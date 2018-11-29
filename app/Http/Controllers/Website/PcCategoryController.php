<?php

namespace App\Http\Controllers\Website;

use App\Services\Api\ApiResponse;
use App\Services\Website\PcCategoryService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PcCategoryController extends Controller
{
    protected $pcCategoryService;

    public function __construct(PcCategoryService $pcCategoryService)
    {
        $this->pcCategoryService = $pcCategoryService;
    }

    public function index()
    {
        $categorys = $this->pcCategoryService->get();
        return view('website.homepage.category', compact('categorys'));
    }

    public function store()
    {
        $item = request()->input('item');
        try {
            DB::beginTransaction();
            $newItem = $this->pcCategoryService->updateOrCreate($item);
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
            $this->pcCategoryService->delete($id);
            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return ApiResponse::failure(g_API_STATUS, '删除失败');
        }

    }
}