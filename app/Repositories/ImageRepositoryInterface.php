<?php

namespace App\Repositories;

interface ImageRepositoryInterface{

    public function selectAll();

    public function find($id);

    public function findBy($query );



    public function delete($query);

    public function uploadImage($request);
    public function deleteImage($request);
    public function setImageCover($request);


//    public function errors();
//
//    public function all(array $related = null);
//
//    public function get($id, array $related = null);
//
//    public function getWhere($column, $value, array $related = null);
//
//    public function getRecent($limit, array $related = null);
//
//    public function create(array $data);
//
//    public function update(array $data);
//
//    public function delete($id);
//
//    public function deleteWhere($column, $value);
    public function deleteImageSingle($imageKey,$slideType);

}
