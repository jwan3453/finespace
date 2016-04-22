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

    public function getCartItems();
    //从cookie 中获取商品
    public function getCartItemsByCookie($cartCookie);
    //同步数据库和cookie中的购物车商品
    public function syncCart($cartArray);
    //加入购物车
    public function addToCart($request);
    //从购物车中删除
    public function deleteFromCart($request);

    //获取购物车商品数量
    public function getCartItemsCount();

    //从数据库中删除整个购物车
    public function deleteCartItems($userId);

    //跟新取货时间
    public function  updateOrderDateTime( $requst);

    //更新取货门店
    public function  updateSelectedStore( $request);
}
