<?php

namespace App\Entities\Good;

use App\Entities\CateAttr\GoodAttrValue;
use App\Entities\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Good.
 *
 * @package namespace App\Entities\Good;
 */
class Good extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'audit_goods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id','category_path','supplier_id','good_code','price','supply_price','good_stock','good_title','good_en_title','good_summary','good_en_summary','main_pic','pic','content','status','created_at','shelf_at','deleted_at','updated_at'];

    public static $syncField = ['id', 'category_id', 'category_path', 'supplier_id', 'good_code', 'brand_name', 'price',
                                'supply_price', 'good_stock', 'orders', 'good_en_title', 'good_summary', 'good_en_summary',
                                'main_pic','pic','content','video'];


    const WAIT_SUBMIT    = 1;   //等待提交
    const WAIT_AUDIT     = 2;   //等待审核
    const WAIT_EDIT      = 3;   //等待编辑
    const EDITED         = 4;   //编辑完成
    const RETURN         = 5;   //退回修改
    const REJECT         = 6;   //已拒绝

    public static $allStatus = [
        self::WAIT_SUBMIT     => '等待提交',
        self::WAIT_AUDIT      => '等待审核',
        self::WAIT_EDIT       => '等待编辑',
        self::EDITED          => '编辑完成',
        self::RETURN          => '退回修改',
        self::REJECT          => '已拒绝',
    ];

    //审核通过按钮
    public static $auditPass = [
        self::WAIT_AUDIT,
    ];
    //退回修改
    public static $auditReturn = [
        self::WAIT_AUDIT,
        self::WAIT_EDIT,
        self::EDITED,
    ];
    //拒绝
    public static $auditReject = [
        self::WAIT_AUDIT,
        self::WAIT_EDIT,
        self::EDITED,
    ];
    //保存编辑
    public static $auditSave = [
        self::WAIT_EDIT,
        self::EDITED,
    ];

    public function getSkus()
    {
        return $this->hasMany(GoodSku::class, "good_id", "id");
    }

    public function hasManyProductAttributes()
    {
        return $this->hasMany(GoodAttrValue::class, 'good_id', 'id');
    }

    public function getImages()
    {
        return $this->hasMany(GoodSkuImage::class, 'good_id', 'id');
    }

    public function getAttrValue()
    {
        return $this->hasMany(GoodAttrValue::class, 'good_id', 'id');
    }

    /**
     * @function 获取正式表的商品数据
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'id');
    }

}
