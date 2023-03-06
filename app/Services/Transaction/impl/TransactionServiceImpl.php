<?php

namespace App\Services\Transaction\impl;

use App\Constants\Table\TableConstant;
use App\Constants\Transaction\TransactionConstant;
use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Transaction\ActiveTransactionRequest;
use App\Http\Requests\Transaction\AddTransactionRequest;
use App\Http\Requests\Transaction\GetAllByRestaurantIdRequest;
use App\Http\Requests\Transaction\PaymentRequest;
use App\Http\Requests\Transaction\UndoPaymentRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Services\Transaction\TransactionService;
use App\Shareds\BaseService;
use App\Shareds\Paginator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionServiceImpl extends BaseService implements TransactionService
{

    const ALLOW_TO_SORT_AND_SEARCH = [
        'status',
    ];

    public function __construct(
        private Transaction $transaction,
        private User $user,
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
                ->latest('created_at')
                ->first();

        if (auth()->user()->role_id == 4 && $data->table->session_id != JWTAuth::getToken()) {
            return (object) [
                'data' => null,
                'status' => 'Unauthorized',
                'statusCode' => 401
            ];
        }

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

        $data['token'] = auth()->login($this->user->where('role_id', 4)->where('restaurant_id', $request->restaurant_id)->first());
        
        $data->table->update(['status' => TableConstant::ONGOING, 'session_id' => $data['token']]);

        return (object) [
            'data' => $data
        ];
    }

    public function payment(PaymentRequest $request) {
        $transaction = $this->find($request->transaction_id);

        if ($transaction->status == TransactionConstant::PAYED) {
            return (object) [
                'data' => null,
                'status' => 'Transaction have been payed. Please undo the transaction first.',
                'statusCode' => 422
            ];
        }

        $transaction->update([
            'status' => TransactionConstant::PAYED,
            'payment' => $request->payment,
        ]);

        $activeTransaction = $this->transaction
                                ->where('table_id', $transaction->table_id)
                                ->where('status', 'on going')
                                ->first();

        if (!$activeTransaction)
            $transaction->table->update(['status' => TableConstant::OPEN]);

        return (object) [
            'data' => $transaction
        ];
    }

    public function undoPayment(UndoPaymentRequest $request) {
        $transaction = $this->find($request->transaction_id);

        if ($transaction->status == TransactionConstant::ONGOING) {
            return (object) [
                'data' => null,
                'status' => 'Transaction is still on going.',
                'statusCode' => 422
            ];
        }

        $transaction->update([
            'status' => TransactionConstant::ONGOING,
            'payment' => null,
        ]);

        $transaction->table->update(['status' => TableConstant::ONGOING]);

        return (object) [
            'data' => $transaction
        ];
    }
}