<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    //

    protected $table = 'shopping_cart';
    protected $fillable =  ['user_id', 'session','has_child_product','parent_product_id', 'product_id',
                            'product_sku', 'count','order_dateTime','selected_store'];

}
