<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Order\AddOrderRequest;
use App\Http\Requests\Order\DeleteOrderRequest;
use App\Http\Requests\Order\GetAllOrderByRestaurantIdRequest;
use App\Http\Requests\Order\GetAllOrderByTransactionIdRequest;
use App\Http\Requests\Order\GetOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Food\IndexCollection;
use App\Http\Resources\Order\DetailResource;
use App\Services\Order\OrderService;
use App\Shareds\ResponseStatus;
use Error;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    )
    {
    }

    /**
     * Function to Get All Order
     * 
     * @param DataTableRequest $request
     * @return ResponseStatus
     */
    public function index(DataTableRequest $request) {
        try {
            $data = $this->orderService->fetch($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get All Order
     * 
     * @param GetAllOrderByRestaurantIdRequest $request
     * @return ResponseStatus
     */
    public function getAllByRestaurantID(GetAllOrderByRestaurantIdRequest $request) {
        try {
            $data = $this->orderService->getAllByRestaurantID($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get All Order
     * 
     * @param GetAllOrderByTransactionIdRequest $request
     * @return ResponseStatus
     */
    public function getAllByTransactionID(GetAllOrderByTransactionIdRequest $request) {
        try {
            $data = $this->orderService->getAllByTransactionID($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data?->meta ?? []], $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get One Order
     * 
     * @param GetOrderRequest $request
     * @return ResponseStatus
     */
    public function show(GetOrderRequest $request) {
        try {
            $data = $this->orderService->find($request->id);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Function to Get One Order
     * 
     * @param AddOrderRequest $request
     * @return ResponseStatus
     */
    public function create(AddOrderRequest $request) {
        try {
            $data = $this->orderService->add($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Update Food
     * 
     * @param UpdateOrderRequest $request
     * @return ResponseStatus
     */
    public function update(UpdateOrderRequest $request) {
        try {
            $data = $this->orderService->updates($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Function to Get All Food in Restaurant by ID
     * 
     * @param DeleteOrderRequest $request
     * @return ResponseStatus
     */
    public function delete(DeleteOrderRequest $request) {
        try {
            $data = $this->orderService->deletes($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

}
