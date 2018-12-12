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
    /**
     * @function 创建时间转化
     * @param $date
     * @return Carbon
     */
    public function getCreatedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 更新时间转化
     * @param $date
     * @return Carbon
     */
    public function getUpdatedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 审核时间转化
     * @param $date
     * @return Carbon
     */
    public function getAuditedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 拒绝时间转化
     * @param $date
     * @return Carbon
     */
    public function getRejectedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 删除时间转化
     * @param $date
     * @return Carbon
     */
    public function getDeletedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 付款时间转化
     * @param $date
     * @return Carbon
     */
    public function getPayAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 发货时间转化
     * @param $date
     * @return Carbon
     */
    public function getDeliveryAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 签收时间转化
     * @param $date
     * @return Carbon
     */
    public function getSignAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 上架时间转化
     * @param $date
     * @return Carbon
     */
    public function getShelfAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 组单时间转化
     * @param $date
     * @return Carbon
     */
    public function getConfirmedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 组单时间转化
     * @param $date
     * @return Carbon
     */
    public function getShippedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 部分到货时间转化
     * @param $date
     * @return Carbon
     */
    public function getPartlyinhouseAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 全部到货时间转化
     * @param $date
     * @return Carbon
     */
    public function getAcceptanceAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 关闭时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getCloseAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 提交审核时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getSubmitAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 编辑完成时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getEditedAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 审核完成时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getAuditAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }

    /**
     * @function 退回修改完成时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getReturnAtAttribute($date)
    {
        if ($date) {
            return Carbon::parse($date)->addHours(8);
        }
        return $date;
    }
}
