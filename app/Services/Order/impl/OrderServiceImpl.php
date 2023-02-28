<?php

namespace App\Services\Order\impl;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Order\AddOrderRequest;
use App\Http\Requests\Order\DeleteOrderRequest;
use App\Http\Requests\Order\GetAllOrderByRestaurantIdRequest;
use App\Http\Requests\Order\GetAllOrderByTransactionIdRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Requests\Transaction\ActiveTransactionRequest;
use App\Models\Food;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\Order\OrderService;
use App\Shareds\BaseService;
use App\Shareds\Paginator;

class OrderServiceImpl extends BaseService implements OrderService
{

    const ALLOW_TO_SORT_AND_SEARCH = [
        'status',
    ];

    public function __construct(
        private Order $order,
        private Transaction $transaction,
        private Food $food,
    )
    {
        parent::__construct($order);
    }

    /**
     * Get All data with pagination, sort, and search
     * 
     * @param DataTableRequest $request
     * @return Paginator
     *
     */
    public function fetch(DataTableRequest $request): Paginator
    {
        $order = getValueOrDefault($request->order, ['desc', 'asc'], 'desc');
        $sort = getValueOrDefault($request->sort, self::ALLOW_TO_SORT_AND_SEARCH, 'id');

        $queryData = $this->order
                    ->with(
                        [
                            'restaurant' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'address']);
                            },
                            'food' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'price', 'category']);
                            }
                        ]
                    )
                    ->select([
                        'id',
                        'restaurant_id',
                        'food_id',
                        'transaction_id',
                        'total',
                        'quantity',
                        'note',
                    ])
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function getAllByRestaurantID(GetAllOrderByRestaurantIdRequest $request) {
        $order = getValueOrDefault($request->order, ['desc', 'asc'], 'desc');
        $sort = getValueOrDefault($request->sort, self::ALLOW_TO_SORT_AND_SEARCH, 'id');

        $queryData = $this->order
                    ->with(
                        [
                            'restaurant' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'address']);
                            },
                            'food' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'price', 'category']);
                            }
                        ]
                    )
                    ->select([
                        'id',
                        'restaurant_id',
                        'food_id',
                        'transaction_id',
                        'total',
                        'quantity',
                        'note',
                    ])
                    ->where('restaurant_id', $request->restaurant_id)
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function getAllByTransactionID(GetAllOrderByTransactionIdRequest $request) {
        $order = getValueOrDefault($request->order, ['desc', 'asc'], 'desc');
        $sort = getValueOrDefault($request->sort, self::ALLOW_TO_SORT_AND_SEARCH, 'id');

        $queryData = $this->order
                    ->with(
                        [
                            'restaurant' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'address']);
                            },
                            'food' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'price', 'category']);
                            }
                        ]
                    )
                    ->select([
                        'id',
                        'restaurant_id',
                        'food_id',
                        'transaction_id',
                        'total',
                        'quantity',
                        'note',
                    ])
                    ->where('transaction_id', $request->transaction_id)
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function find(int $id) {
        return $this->findById($id);
    }

    public function add(AddOrderRequest $request) {
        $transaction = $this->transaction
                        ->where('id', $request->transaction_id)
                        ->first();

        if ($transaction->status != 'on going')
            return (object) [
                'data' => null,
                'status' => 'No Active Transaction',
                'statusCode' => 404
            ];

        
        $addValue = [];
        foreach ($request->orders as $order) {
            $order = (object) $order;

            $food = $this->food->find($order->food_id);

            if ($food->quantity - $order->quantity < 0)
                return (object) [
                    'data' => null,
                    'status' => "$food->name ($food->id) is Out of Stock. (Remaining: $food->quantity)",
                    'statusCode' => 422
                ];

            array_push($addValue, $this->order->create([
                'restaurant_id' => (int) $request->restaurant_id,
                'transaction_id' => (int) $request->transaction_id,
                'food_id' => $order->food_id,
                'status' => 'on process',
                'total' => $order->quantity * $food->price,
                'quantity' => $order->quantity,
                'note' => $order->note,
            ]));

            $food->quantity = $food->quantity - $order->quantity;
            $food->save();
        }

        return (object) [
            'data' => $addValue
        ];
    }

    public function updates(UpdateOrderRequest $request) {
        $order = $this->find($request->order_id);
        $order->update($request->all());

        return $order;
    }

    public function deletes(DeleteOrderRequest $request) {
        $order = $this->find($request->order_id);
        $order->delete($request->order_id);

        return $order;
    }
}