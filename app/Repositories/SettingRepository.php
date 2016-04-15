<?php
namespace App\Repositories;

use App\Models\AdSlide;


class SettingRepository implements SettingRepositoryInterface{


    public function getHomeSlides()
    {
       return AdSlide::where('type',1)->get();
    }

}


