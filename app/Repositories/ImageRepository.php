<?php
namespace App\Repositories;
use App\Models\Image;


class ImageRepository implements  ImageRepositoryInterface{

    public function selectAll()
    {
        return Image::all();
    }

    public function find($id)
    {
        return Image::find($id);
    }


    public function findBy($query){

        return Image::where($query)->get();
    }
    public function save($obj)
    {

        $newImage = new Image();
        $newImage->type = $obj['type'];
        $newImage->associateId = $obj['associateId'];
        $newImage->key = $obj['key'];
        $newImage->link = $obj['link'];
        $newImage->save();
        return $newImage;

    }

    public function delete($query)
    {
       return  $deletedRows = Image::where($query)->delete();
    }

}


