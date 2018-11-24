<?php

namespace App\Http\Controllers\Website;

use App\Services\Api\ApiResponse;
use App\Services\CateAttr\CategoryService;
use App\Services\Website\IconService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IconController extends Controller
{
    protected $iconService;
    protected $categoryService;

    public function __construct(IconService $iconService, CategoryService $categoryService)
    {
        $this->iconService = $iconService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        \request()->flash();
        $option = [];
        if (\request()->filled('title')) {
            $option = array_merge($option, [['title', 'like', '%' . \request()->get('title') . '%']]);
        }
        if (\request()->filled('daterange')) {
            $time = explode('~', \request()->query('daterange'));

            $option = array_merge($option, [['start_at', '>=', $time[0]]]);

            $option = array_merge($option, [['start_at', '<', $time[1]]]);
        }
        return view('website.icons.index', ['icons' => $this->iconService->getIcons($option)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        ;
        return view('website.icons.edit', ['categorys' => $this->getCategorys()]);
    }

    public function getCategorys()
    {
        return $this->categoryService->getCategoryByLevel(1, ['name', 'id']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $validator = $this->validate($request,
                $rules = [
                    'title' => 'required',
                    'src' => 'required',
                    'category_id' => 'required',
                    'sort' => 'required',
                    'time_duration' => 'required'
                ]
            );
            $id = $this->iconService->createIcon($validator);
            return ApiResponse::success($id);
        } catch (\Exception $e) {
            dd($e);
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('website.icons.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('website.icons.edit', ['categorys' => $this->getCategorys(), 'icon' => $this->iconService->getIconInfo($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $validator = $this->validate($request,
                $rules = [
                    'title' => 'required',
                    'src' => 'required',
                    'category_id' => 'required',
                    'sort' => 'required',
                    'time_duration' => 'required'
                ]
            );
            $this->iconService->updateIconInfo($validator, $id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $this->iconService->delete($id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, '删除失败');
        }

    }
}
