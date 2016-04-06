<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected  $table = 'orders';

    protected $fillable = ['order_no', 'user_id', 'address_id', 'recipient_id','shipping_id',
                            'payment_id','delivery_time','total_amount','shipping_fee','shipping_fee',
                            'status','shipping_status','pay_status'];


    public function orderItems()
    {

       return $this->hasMany('App\Models\OrderItem','order_id');

    }
}
