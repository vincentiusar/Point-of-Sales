<?php

namespace App\Services\Order\impl;

use App\Constants\Transaction\TransactionConstant;
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
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $transaction = $this->transaction->find($request->transaction_id);
        if (auth()->user()->role_id == 4 && $transaction->table->session_id != JWTAuth::getToken()) {
            return (object) [
                'items' => [],
                'status' => 'Unauthorized',
                'statusCode' => 401
            ];
        }

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
                        'status',
                        'total',
                        'quantity',
                        'note',
                    ])
                    ->where('transaction_id', $request->transaction_id)
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page ?? 1000);
    }

    public function find(int $id) {
        return $this->findById($id);
    }

    public function add(AddOrderRequest $request) {
        $transaction = $this->transaction
                        ->with(['orders.food'])
                        ->where('id', $request->transaction_id)
                        ->where('status', TransactionConstant::ONGOING)
                        ->first();

        if (auth()->user()->role_id == 4 && $transaction->table->session_id != JWTAuth::getToken()) {
            return (object) [
                'data' => null,
                'status' => 'Unauthorized',
                'statusCode' => 401
            ];
        }

        if (!$transaction)
            return (object) [
                'data' => null,
                'status' => 'No Active Transaction',
                'statusCode' => 404
            ];

        $foods = $this->food->whereIn('id', collect($request->orders)->pluck('food_id'))->get();

        foreach ($request->orders as $order) {
            $order = (object) $order;
            $food = $foods[array_search($order->food_id, array_column($foods->toArray(), 'id'))];   // find index of foods that have food_id = order_id
            $prevOrdered = array_search($order->food_id, array_column($transaction->orders->toArray(), 'food_id'));
            
            $foodQuantity = $food->quantity;
            if ($prevOrdered !== false) {
                $foodQuantity += $transaction->orders[$prevOrdered]?->quantity;
            }

            if ($foodQuantity - $order->quantity < 0)
                return (object) [
                    'data' => null,
                    'status' => "$food->name ($food->id) is Out of Stock. (Remaining: $food->quantity)",
                    'statusCode' => 422
                ];

            if ($prevOrdered !== false && $transaction->orders[$prevOrdered]?->quantity > $order->quantity) {
                return (object) [
                    'data' => null,
                    'status' => "$food->name ($food->id) Cannot be cancel. Before: " . $transaction->orders[$prevOrdered]->quantity . ", Now: $order->quantity",
                    'statusCode' => 422
                ];
            }
        }

        $transaction->total = 0;
        foreach ($request->orders as $order) {
            $order = (object) $order;
            $food = $foods[array_search($order->food_id, array_column($foods->toArray(), 'id'))];

            $transaction->orders()->updateOrCreate(
                [
                    'restaurant_id' => (int) $request->restaurant_id,
                    'transaction_id' => (int) $request->transaction_id,
                    'food_id' => $order->food_id,
                ],
                [
                    'status' => 'on process',
                    'total' => $order->quantity * $food->price,
                    'quantity' => $order->quantity,
                    'note' => $order->note,
                ]
            );

            $transaction->total += $order->quantity * $food->price;

            $updateValueFood = array_search($food->id, array_column($transaction->orders->toArray(), 'food_id'));
            if ($updateValueFood !== false) {
                $food->quantity += ($transaction->orders[$updateValueFood]?->quantity ?? 0) - $order->quantity;
            } else {
                $food->quantity -= $order->quantity;
            }

            $food->save();
        }

        $transaction->save();

        return (object) [
            'data' => $transaction
        ];
    }

    public function updates(UpdateOrderRequest $request) {
        $transaction = $this->transaction
                        ->with(['orders.food'])
                        ->where('id', $request->transaction_id)
                        ->where('status', TransactionConstant::ONGOING)
                        ->first();

        if (!$transaction)
            return (object) [
                'data' => null,
                'status' => 'No Active Transaction',
                'statusCode' => 404
            ];

        $foods = $this->food->whereIn('id', collect($transaction->orders)->pluck('food_id'))->get();
        
        foreach ($request->orders as $order) {
            $order = (object) $order;
            $order = array_search($order->order_id, array_column($transaction->orders->toArray(), 'id'));

            if ($order !== false) {
                $order = $transaction->orders[$order];
            }
            $food = $foods[array_search($order->food_id, array_column($foods->toArray(), 'id'))];   // find index of foods that have food_id = order_id

            if ($food->quantity - $order->quantity < 0)
                return (object) [
                    'data' => null,
                    'status' => "$food->name ($food->id) is Out of Stock. (Remaining: $food->quantity)",
                    'statusCode' => 422
                ];
        }

        $transaction->total = 0;
        foreach ($request->orders as $value) {
            $value = (object) $value;
            $order = array_search($value->order_id, array_column($transaction->orders->toArray(), 'id'));

            if ($order !== false) {
                $order = $transaction->orders[$order];
            }
            $food = $foods[array_search($order->food_id, array_column($foods->toArray(), 'id'))];
            
            $transaction->total += $value->quantity * $food->price;
            
            $updateValueFood = array_search($food->id, array_column($transaction->orders->toArray(), 'food_id'));
            if ($updateValueFood !== false) {
                $food->quantity += ($transaction->orders[$updateValueFood]?->quantity ?? 0) - $value->quantity;
            } else {
                $food->quantity -= $value->quantity;
            }
            
            $order->update(
                [
                    'status' => 'on process',
                    'total' => $value->quantity * $food->price,
                    'quantity' => $value->quantity,
                ]
            );

            $food->save();
        }

        $transaction->save();

        return (object) [
            'data' => $transaction
        ];
    }

    public function deletes(DeleteOrderRequest $request) {
        $order = $this->find($request->order_id);

        if ($order->transaction->status != TransactionConstant::ONGOING) {
            return (object) [
                'data' => null,
                'status' => 'No Active Transaction',
                'statusCode' => 404
            ];
        }

        $order->food->quantity += $order->quantity;
        $order->food->save();

        $order->transaction->total -= $order->food->price * $order->quantity;
        $order->transaction->save();

        $order->delete($request->order_id);

        return $order;
    }
}