<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected  $table = 'order_item';


    protected $fillable = ['order_id', 'product_id', 'parent_product_id', 'count','product_detail'];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id','product_id');
    }
}
