<?php

namespace App\Repositories;

interface OrderRepositoryInterface {

    public function selectAll($paginate = 0);

    public function find($id);

    public function findBy($query );

//    public function save($obj);


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
    public function updatePaymentMethod( $request);
//
//    public function delete($id);
//
//    public function deleteWhere($column, $value);


    public function  getOrderDetail($orderNo);

    public function  generateOrder($request);

    public function getAllOrder($paymentStatus);

    public function seachOrder($seachData,$paginate);

    public function StockingOrder();

    public function seachStatementData($order_no);

}
