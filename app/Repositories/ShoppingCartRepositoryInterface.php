<?php

namespace App\Repositories;

interface ShoppingCartRepositoryInterface{

    public function selectAll();

    public function find($id);

    public function findBy($query);

    public function deleteBy($query);

    public function save($obj);

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

    public function getCartItems($cartCookie);
    public function syncCart($cartArray);
    public function addToCart($request);

}
