<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdSlide extends Model
{
    //
    protected $table = 'ad_slide';

    protected $fillable = ['type','key','link'];
}
