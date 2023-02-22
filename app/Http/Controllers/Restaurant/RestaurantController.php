<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Restaurant\GetRestaurantRequest;
use App\Http\Requests\Restaurant\UpdateRestaurantRequest;
use App\Http\Resources\Restaurant\DetailResource;
use App\Http\Resources\Restaurant\IndexCollection;
use App\Services\Restaurant\RestaurantService;
use App\Shareds\ResponseStatus;
use Error;

class RestaurantController extends Controller
{

    public function __construct(
        private RestaurantService $restaurantService,
    )
    {
    }

    /**
     * Get Restaurant Data (paginated)
     * 
     * @param DataTableRequest $request
     * @return ResponseStatus
     */
    public function index(DataTableRequest $request)
    {
        try {
            $data = $this->restaurantService->fetch($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Get Restaurant by ID
     * 
     * @param GetRestaurantRequest $id
     * @return ResponseStatus
     */
    public function show(GetRestaurantRequest $request)
    {
        try {
            $data = $this->restaurantService->find((int) $request->id);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Get Restaurant by User Token
     * 
     * @param int $id
     * @return ResponseStatus
     */
    public function showByToken()
    {
        try {
            $data = $this->restaurantService->find(auth()->user()->restaurant_id);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Update Restaurant by ID
     * 
     * @param UpdateRestaurantRequest $request
     * @return ResponseStatus
     */
    public function update(UpdateRestaurantRequest $request)
    {
        try {
            

            $data = null;

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

}
