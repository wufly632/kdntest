<?php
// +----------------------------------------------------------------------
// | KDNiaoController.php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Time: 2018/12/10 下午9:45
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Services\Common\KDNiaoService;

class KDNiaoController extends Controller
{
    public function receive()
    {
        return app(KDNiaoService::class)->receiveLogistics();
    }
}
