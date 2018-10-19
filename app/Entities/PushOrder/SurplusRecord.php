<?php

namespace App\Entities\PushOrder;

use Illuminate\Database\Eloquent\Model;

class SurplusRecord extends Model
{
    protected $table = 'push_surplus_records';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sku_id','num','note','batch_id','created_at','updated_at'];
}
