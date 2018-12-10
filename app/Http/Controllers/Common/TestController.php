<?php
// +----------------------------------------------------------------------
// | TestController.php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Time: 2018/12/10 下午3:15
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Wufly\Kuaidiniao\KuaidiniaoService;

class TestController extends Controller
{
    public function kdnView()
    {
        $ShipperCode = 'SF';
        $LogisticCode = '1234561';
        $test = app(KuaidiniaoService::class)->getOrderTracesByJson($ShipperCode,$LogisticCode);
        dd($test);
        return view('test');
    }
}
