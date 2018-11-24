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
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 更新时间转化
     * @param $date
     * @return Carbon
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 审核时间转化
     * @param $date
     * @return Carbon
     */
    public function getAuditedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 拒绝时间转化
     * @param $date
     * @return Carbon
     */
    public function getRejectedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 删除时间转化
     * @param $date
     * @return Carbon
     */
    public function getDeletedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 付款时间转化
     * @param $date
     * @return Carbon
     */
    public function getPayAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 发货时间转化
     * @param $date
     * @return Carbon
     */
    public function getDeliveryAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 签收时间转化
     * @param $date
     * @return Carbon
     */
    public function getSignAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 上架时间转化
     * @param $date
     * @return Carbon
     */
    public function getShelfAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 组单时间转化
     * @param $date
     * @return Carbon
     */
    public function getConfirmedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 组单时间转化
     * @param $date
     * @return Carbon
     */
    public function getShippedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 部分到货时间转化
     * @param $date
     * @return Carbon
     */
    public function getPartlyinhouseAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 全部到货时间转化
     * @param $date
     * @return Carbon
     */
    public function getAcceptanceAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 关闭时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getCloseAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 提交审核时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getSubmitAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 编辑完成时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getEditedAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 审核完成时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getAuditAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }

    /**
     * @function 退回修改完成时间时间转化
     * @param $date
     * @return Carbon
     */
    public function getReturnAtAttribute($date)
    {
        return Carbon::parse($date)->addHours(8);
    }
}
