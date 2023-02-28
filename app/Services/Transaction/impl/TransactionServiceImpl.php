<?php

namespace App\Services\Transaction\impl;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Transaction\ActiveTransactionRequest;
use App\Http\Requests\Transaction\AddTransactionRequest;
use App\Http\Requests\Transaction\GetAllByRestaurantIdRequest;
use App\Models\Transaction;
use App\Services\Transaction\TransactionService;
use App\Shareds\BaseService;
use App\Shareds\Paginator;

class TransactionServiceImpl extends BaseService implements TransactionService
{

    const ALLOW_TO_SORT_AND_SEARCH = [
        'status',
    ];

    public function __construct(
        private Transaction $transaction,
    )
    {
        parent::__construct($transaction);
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

        $queryData = $this->transaction
                    ->with(
                        [
                            'restaurant' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'address']);
                            }
                        ]
                    )
                    ->select([
                        'id',
                        'restaurant_id',
                        'table_id',
                        'status',
                        'payment',
                        'total',
                    ])
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request) {
        $order = getValueOrDefault($request->order, ['desc', 'asc'], 'desc');
        $sort = getValueOrDefault($request->sort, self::ALLOW_TO_SORT_AND_SEARCH, 'id');

        $queryData = $this->transaction
                    ->select([
                        'id',
                        'restaurant_id',
                        'table_id',
                        'status',
                        'payment',
                        'total',
                    ])
                    ->where('restaurant_id', $request->restaurant_id)
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function activeTransactionOnTable(ActiveTransactionRequest $request) {
        $data = $this->transaction
                ->select([
                    'id',
                    'restaurant_id',
                    'table_id',
                    'status',
                    'payment',
                    'total',
                ])
                ->where('table_id', $request->id)
                ->where('status', 'on going')
                ->first();

        return $data ? 
            (object) [
                'data' => $data,
            ] : 
            (object) [
                'data' => null,
                'status' => 'No Active Transaction',
                'statusCode' => 404
            ];
    }

    public function find(int $id) {
        return $this->findById($id);
    }

    public function add(AddTransactionRequest $request) {
        $activeTransaction = $this->transaction
                                ->where('table_id', $request->table_id)
                                ->where('status', 'on going')
                                ->first();

        if ($activeTransaction) 
            return (object) [
                'data' => null,
                'status' => 'Another Transaction is Currently on Going',
                'statusCode' => 422
            ];

        $data = $this->transaction->create(
            [
                'restaurant_id' => $request->restaurant_id,
                'table_id' => $request->table_id,
                'status' => 'on going',
                'total' => 0,
            ]
        );

        return (object) [
            'data' => $data
        ];
    }
}