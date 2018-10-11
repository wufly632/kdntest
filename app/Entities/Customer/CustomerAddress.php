<?php

namespace App\Entities\Customer;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CustomerAddress extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'customers_address';

    protected $fillable = [];

}