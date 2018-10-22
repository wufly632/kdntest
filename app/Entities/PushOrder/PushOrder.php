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
    protected $fillable = ['requirement_id','batch_id','pre_ship_order_id','created_at','updated_at'];
}
