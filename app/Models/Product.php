<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table =  'product';
    public $timestamps = false;



    protected $fillable =['category_id','brand_id','sku','name','inventory','limit_per_day','stock_alarm',
                          'price','promote_price','promote_start_date','promote_end_date','keywords',
                            'brief','desc','status','is_promote','is_new','is_hot','is_recommend'];


    public function specifications()
    {
        return $this->hasMany('App\Models\ProductSpec','product_id');
    }

}
