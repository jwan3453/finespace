<?php

namespace App\Repositories;

interface ProductRepositoryInterface{

    public function selectAll($paginate = 0);

    public function find($id);

//    public function findBy($query );


    public function save($obj);

    public function update($obj);



    public function getProductDetail($productId);
    public function addProduct($request);
    public function updateProduct($request);

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

}
