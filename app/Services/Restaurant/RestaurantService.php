<?php

namespace App\Services\Restaurant;

use App\Http\Requests\DataTableRequest;

interface RestaurantService
{
    public function find(int $id);
    public function fetch(DataTableRequest $request);
    public function updateRestaurant(int $id);
}