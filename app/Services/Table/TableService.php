<?php

namespace App\Services\Table;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Table\AddTableRequest;
use App\Http\Requests\Table\DeleteTableRequest;
use App\Http\Requests\Table\GetAllByRestaurantIdRequest;
use App\Http\Requests\Table\UpdateTableRequest;

interface TableService
{
    public function find(int $id);
    public function fetch(DataTableRequest $request);
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request);
    public function add(AddTableRequest $request);
    public function updates(UpdateTableRequest $request);
    public function deletes(DeleteTableRequest $request);
}