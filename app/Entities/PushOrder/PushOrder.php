<?php

namespace App\Entities\PushOrder;

use Illuminate\Database\Eloquent\Model;

class PushOrder extends Model
{
    protected $table = 'push_orders';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['batch_id','supplier_id','good_id','sku_id','num','supply_price','accepted',
                           'need_num','status','created_at','updated_at'];
}
