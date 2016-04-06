<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    //
    protected $table =  'product_spec';
    public $timestamps = false;

    public function specInfo()
    {
        return $this->hasOne('App\Models\SpecInfo', 'id','spec_info_id');
    }
}
