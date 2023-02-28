<?php

namespace App\Services\Order;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Order\AddOrderRequest;
use App\Http\Requests\Order\DeleteOrderRequest;
use App\Http\Requests\Order\GetAllOrderByRestaurantIdRequest;
use App\Http\Requests\Order\GetAllOrderByTransactionIdRequest;
use App\Http\Requests\Order\UpdateOrderRequest;

interface OrderService
{
    public function find(int $id);
    public function fetch(DataTableRequest $request);
    public function getAllByRestaurantID(GetAllOrderByRestaurantIdRequest $request);
    public function getAllByTransactionID(GetAllOrderByTransactionIdRequest $request);
    public function add(AddOrderRequest $request);
    public function updates(UpdateOrderRequest $request);
    public function deletes(DeleteOrderRequest $request);
}