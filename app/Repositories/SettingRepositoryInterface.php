<?php

namespace App\Repositories;

interface SettingRepositoryInterface{

    public function getHomeSlides();
    public function updateSlide($request);
    public function deleteSlide($request);

}
