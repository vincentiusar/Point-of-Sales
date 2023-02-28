<?php

namespace App\Services\Food;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Requests\Food\DeleteFoodRequest;
use App\Http\Requests\Food\GetAllByRestaurantIdRequest;
use App\Http\Requests\Food\UpdateFoodRequest;

interface FoodService
{
    public function find(int $id);
    public function fetch(DataTableRequest $request);
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request);
    public function add(AddFoodRequest $request);
    public function updates(UpdateFoodRequest $request);
    public function deletes(DeleteFoodRequest $request);
}