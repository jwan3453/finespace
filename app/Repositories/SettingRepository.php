<?php
namespace App\Repositories;

use App\Models\AdSlide;


class SettingRepository implements SettingRepositoryInterface{


    public function getHomeSlides()
    {
       return AdSlide::where('type',1)->get();
    }
    public function updateSlide($request)
    {

        $slideId = $request->input('slideId');
        $adLink = $request->input('adLink');
        return AdSlide::where('id',$slideId )->update(['ad_link'=>$adLink]);
    }

    public function deleteSlide($request)
    {

        $slideId = $request->input('slideId');
        return AdSlide::where('id',$slideId )->delete();
    }


}


