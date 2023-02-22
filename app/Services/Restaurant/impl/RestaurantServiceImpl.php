<?php

namespace App\Services\Restaurant\impl;

use App\Http\Requests\DataTableRequest;
use App\Models\Restaurant;
use App\Services\Restaurant\RestaurantService;
use App\Shareds\BaseService;
use App\Shareds\Paginator;

class RestaurantServiceImpl extends BaseService implements RestaurantService
{

    const ALLOW_TO_SORT_AND_SEARCH = [
        'name',
        'address',
        'description',
    ];

    public function __construct(
        private Restaurant $restaurant,
    )
    {
        parent::__construct($restaurant);
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

        $queryData = $this->restaurant
                    ->select([
                        'id',
                        'admin_id',
                        'name',
                        'description',
                        'address',
                    ])
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->search%");
                    })
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function find(int $id) {
        return $this->findById($id);
    }

    public function updateRestaurant(int $id) 
    {
        
    }
}