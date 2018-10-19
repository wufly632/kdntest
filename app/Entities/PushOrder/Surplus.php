<?php

namespace App\Entities\PushOrder;

use Illuminate\Database\Eloquent\Model;

class Surplus extends Model
{
    protected $table = 'push_surplus';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sku_id','num','created_at','updated_at'];
}
