<?php

namespace App\Services\Transaction;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Transaction\ActiveTransactionRequest;
use App\Http\Requests\Transaction\AddTransactionRequest;
use App\Http\Requests\Transaction\GetAllByRestaurantIdRequest;
use App\Http\Requests\Transaction\PaymentRequest;
use App\Http\Requests\Transaction\UndoPaymentRequest;

interface TransactionService
{
    public function find(int $id);
    public function fetch(DataTableRequest $request);
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request);
    public function activeTransactionOnTable(ActiveTransactionRequest $request);
    public function add(AddTransactionRequest $request);
    public function payment(PaymentRequest $request);
    public function undoPayment(UndoPaymentRequest $request);
    // public function deletes(DeleteTableRequest $request);
}