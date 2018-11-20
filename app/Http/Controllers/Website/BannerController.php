<?php

namespace App\Http\Controllers\Website;

use App\Services\Api\ApiResponse;
use App\Services\Api\CommonService;
use App\Services\Currency\CurrencyService;
use App\Services\Website\BannerService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class BannerController extends Controller
{

    protected $bannerService;
    protected $currencyService;

    public function __construct(BannerService $bannerService, CurrencyService $currencyService)
    {
        $this->bannerService = $bannerService;
        $this->currencyService = $currencyService;
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
        if (\request()->filled('type')) {
            $option = array_merge($option, ['type' => \request()->get('type')]);
        }
        if (\request()->filled('title')) {
            $option = array_merge($option, [['title', 'like', '%' . \request()->get('title') . '%']]);
        }
        if (\request()->filled('daterange')) {
            $time = explode('~', \request()->query('daterange'));

            $option = array_merge($option, [['start_at', '>=', $time[0]]]);

            $option = array_merge($option, [['start_at', '<', $time[1]]]);
        }
        return view('website.banners.index', ['banners' => $this->bannerService->getAllBanner($option)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $currencys = $this->currencyService->getAll();
        return view('website.banners.edit', ['currencys' => $currencys]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->validate($request,
                $rules = [
                    'title' => 'required',
                    'src' => 'required',
                    'describe' => '',
                    'link' => 'required',
                    'type' => 'required',
                    'sort' => 'required',
                    'time_duration' => 'required',
                    'currency_code' => 'required',
                ]
            );
            $banner = $this->bannerService->createBannerInfo($validator);
            return ApiResponse::success(['id' => $banner->id]);
        } catch (\Exception $e) {
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
        $banner = $this->bannerService->getBannerInfo($id);
        $currencys = $this->currencyService->getAll();
        return view('website.banners.edit', ['banner' => $banner, 'currencys' => $currencys]);
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
        try {
            $validator = $this->validate($request,
                $rules = [
                    'title' => 'required',
                    'src' => 'required',
                    'describe' => '',
                    'link' => 'required',
                    'type' => 'required',
                    'sort' => 'required',
                    'time_duration' => 'required',
                    'currency_code' => 'required'
                ]
            );
            $this->bannerService->updateBannerInfo($validator, $id);
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
        try {
            $this->bannerService->deleteBannerInfo($id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::failure(g_API_ERROR, '删除失败');
        }
    }

    public function uploadImages(Request $request)
    {
        $dirName = $request->input('dir_name');
        if (!in_array($dirName, $this->getAllowDir())) {
            return ApiResponse::failure(g_API_ERROR, '图片上传失败');
        }
        $img = $request->file($dirName);
        if ($request->hasFile($dirName) && $img->isValid()) {
            $ext = $img->getClientOriginalExtension();
            if (!in_array(strtolower($ext), ['jpg', 'png', 'bmp', 'wbmp', 'jpeg'])) {
                return ApiResponse::failure(g_API_ERROR, '图片格式不正确，请检查!');
            }
            $directory = $dirName;
            $ali = false;
            $bucket = null;
            if (env('APP_ENV', 'local') == 'production') {
                $ali = true;
            }
            $urlInfo = app(CommonService::class)->uploadFile($file = $dirName, $directory, $ali, false, false);
            if ($urlInfo) {
                if ($ali) {
                    return ApiResponse::success($urlInfo['oss-request-url'], '图片上传成功');
                } else {
                    return ApiResponse::success($urlInfo, '图片上传成功');
                }
            } else {
                return ApiResponse::failure(g_API_ERROR, '图片上传失败!');
            }
        } else {
            return ApiResponse::failure(g_API_ERROR, '图片上传失败!');
        }

    }

    public function getAllowDir()
    {
        return [
            'icons',
            'banners',

        ];
    }
}
