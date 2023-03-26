<?php

namespace App\Services\Restaurant;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Restaurant\DeleteRestaurantRequest;
use App\Http\Requests\Restaurant\UpdateRestaurantByIDRequest;
use App\Http\Requests\Restaurant\UpdateRestaurantRequest;

interface RestaurantService
{
    public function find(int $id);
    public function showAllByAdmin(int $id);
    public function fetch(DataTableRequest $request);
    public function updateRestaurant(UpdateRestaurantRequest|UpdateRestaurantByIDRequest $request);
    public function deleteById(DeleteRestaurantRequest $request);
}