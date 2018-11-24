<?php
// +----------------------------------------------------------------------
// | ProductLogService.php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Time: 2018/11/22 下午9:55
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Services\Product;

use App\Entities\Product\ProductOnOffline;
use Carbon\Carbon;

class ProductLogService
{
    public function __construct()
    {
    }

    /**
     * @function 添加商品上下架操作记录
     * @param $id
     * @param $type
     */
    public function addOnOfflineLog($id, $type, $user_id=null)
    {
        $operator_id = $user_id ?: \Auth::id();
        $data = [
            'good_id' => $id,
            'type' => $type,
            'operator_id' => $operator_id,
            'created_at' => Carbon::now()->toDateTimeString(),
        ];
        ProductOnOffline::insert($data);
    }
}
