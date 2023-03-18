<?php

namespace App\Services\Food\impl;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Requests\Food\DeleteFoodRequest;
use App\Http\Requests\Food\GetAllByRestaurantIdRequest;
use App\Http\Requests\Food\GetMultipleFood;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Models\Food;
use App\Services\Food\FoodService;
use App\Shareds\BaseService;
use App\Shareds\Paginator;

class FoodServiceImpl extends BaseService implements FoodService
{

    const ALLOW_TO_SORT_AND_SEARCH = [
        'name',
        'status',
        'category'
    ];

    public function __construct(
        private Food $food,
    )
    {
        parent::__construct($food);
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

        $queryData = $this->food
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
                        'name',
                        'description',
                        'quantity',
                        'price',
                        'category',
                        'image'
                    ])
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->search%");
                    })
                    ->when($request->category, function ($query) use ($request) {
                        return $query->where('category', $request->category);
                    })
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request) {
        $order = getValueOrDefault($request->order, ['desc', 'asc'], 'desc');
        $sort = getValueOrDefault($request->sort, self::ALLOW_TO_SORT_AND_SEARCH, 'id');

        $queryData = $this->food
                    ->select([
                        'id',
                        'restaurant_id',
                        'name',
                        'description',
                        'quantity',
                        'price',
                        'category',
                        'image'
                    ])
                    ->where('restaurant_id', $request->restaurant_id)
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->search%");
                    })
                    ->when($request->category, function ($query) use ($request) {
                        return $query->where('category', $request->category);
                    })
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function find(int $id) {
        return $this->findById($id);
    }

    public function findMany(GetMultipleFood $request) {
        $ids = collect($request->foods)->pluck('food_id');

        $queryData = $this->food
                    ->whereIn('id', $ids);

        return Paginator::paginate($queryData, $request->page, 1000);
    }

    public function add(AddFoodRequest $request) {
        $data = $this->food->create($request->all());

        return $data;
    }

    public function updates(UpdateFoodRequest $request) {
        $table = $this->find($request->id);
        $table->update($request->all());

        return $table;
    }

    public function deletes(DeleteFoodRequest $request) {
        $table = $this->find($request->id);
        $table->delete($request->id);

        return $table;
    }
}