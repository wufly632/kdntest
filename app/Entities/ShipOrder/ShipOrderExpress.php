<?php

namespace App\Entities\ShipOrder;

use Illuminate\Database\Eloquent\Model;

class ShipOrderExpress extends Model
{
    protected $table = 'ship_order_express';

    protected $fillable = ['ship_order_id', 'shipper_code', 'waybill_id', 'created_at', 'updated_at'];
}
