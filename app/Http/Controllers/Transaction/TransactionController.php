<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Transaction\ActiveTransactionRequest;
use App\Http\Requests\Transaction\AddTransactionRequest;
use App\Http\Requests\Transaction\GetAllByRestaurantIdRequest;
use App\Http\Requests\Transaction\GetTransactionRequest;
use App\Http\Requests\Transaction\PaymentRequest;
use App\Http\Requests\Transaction\UndoPaymentRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\Transaction\AllTransactionCollection;
use App\Http\Resources\Transaction\DetailResource;
use App\Http\Resources\Transaction\IndexCollection;
use App\Services\Transaction\TransactionService;
use App\Shareds\ResponseStatus;
use Error;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
    public function __construct(
        private TransactionService $transactionService
    )
    {   
    }

    /**
     * Function to Get All Transaction
     * 
     * @param DataTableRequest $request
     * @return ResponseStatus
     */
    public function index(DataTableRequest $request) {
        try {
            $data = $this->transactionService->fetch($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get All Table in Restaurant by ID
     * 
     * @param GetAllByRestaurantIdRequest $request
     * @return ResponseStatus
     */
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request) {
        try {
            $data = $this->transactionService->getAllByRestaurantID($request);

            return ResponseStatus::response(['items' => new AllTransactionCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to current active transaction on table
     * 
     * @param ActiveTransactionRequest $request
     * @return ResponseStatus
     */
    public function activeTransactionOnTable(ActiveTransactionRequest $request) {
        try {
            $data = $this->transactionService->activeTransactionOnTable($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Function to Get One Transaction
     * 
     * @param GetTransactionRequest $request
     * @return ResponseStatus
     */
    public function show(GetTransactionRequest $request) {
        try {
            $data = $this->transactionService->find($request->id);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Create One Transaction
     * 
     * @param AddTransactionRequest $request
     * @return ResponseStatus
     */
    public function create(AddTransactionRequest $request) {
        try {
            $data = $this->transactionService->add($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Refresh token One Transaction
     * 
     * @param AddTransactionRequest $request
     * @return ResponseStatus
     */
    public function refreshToken(AddTransactionRequest $request) {
        try {
            $data = $this->transactionService->refreshToken($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Function to Pay One Transaction
     * 
     * @param PaymentRequest $request
     * @return ResponseStatus
     */
    public function payment(PaymentRequest $request) {
        try {
            $data = $this->transactionService->payment($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Update One Transaction
     * 
     * @param UndoPaymentRequest $request
     * @return ResponseStatus
     */
    public function undoPayment(UndoPaymentRequest $request) {
        try {
            $data = $this->transactionService->undoPayment($request);

            return ResponseStatus::response(new DetailResource($data->data), $data?->status ?? null, $data?->statusCode ?? 200);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

}
