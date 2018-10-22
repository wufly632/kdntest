<?php
// +----------------------------------------------------------------------
// | DateToLocalShowTrait.php
// +----------------------------------------------------------------------
// | Description: 显示时间转换为本地
// +----------------------------------------------------------------------
// | Time: 2018/10/22 上午10:20
// +----------------------------------------------------------------------
// | Author: wufly <wfxykzd@163.com>
// +----------------------------------------------------------------------

namespace App\Entities\CommonTrait;

use Carbon\Carbon;

trait DateToLocalShowTrait
{
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }
}
