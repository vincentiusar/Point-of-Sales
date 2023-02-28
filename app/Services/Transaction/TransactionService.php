<?php

namespace App\Services\Transaction;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Transaction\ActiveTransactionRequest;
use App\Http\Requests\Transaction\AddTransactionRequest;
use App\Http\Requests\Transaction\GetAllByRestaurantIdRequest;

interface TransactionService
{
    public function find(int $id);
    public function fetch(DataTableRequest $request);
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request);
    public function activeTransactionOnTable(ActiveTransactionRequest $request);
    public function add(AddTransactionRequest $request);
    // public function updates(UpdateTableRequest $request);
    // public function deletes(DeleteTableRequest $request);
}