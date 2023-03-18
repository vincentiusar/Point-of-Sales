<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Food\AddFoodRequest;
use App\Http\Requests\Food\DeleteFoodRequest;
use App\Http\Requests\Food\GetAllByRestaurantIdRequest;
use App\Http\Requests\Food\GetFoodRequest;
use App\Http\Requests\Food\GetMultipleFood;
use App\Http\Requests\Food\UpdateFoodRequest;
use App\Http\Resources\Food\AllFoodCollection;
use App\Http\Resources\Food\DetailResource;
use App\Http\Resources\Food\IndexCollection;
use App\Services\Food\FoodService;
use App\Shareds\ResponseStatus;
use Error;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function __construct(
        private FoodService $foodService,
    )
    {
    }

    /**
     * Get Food Data (paginated)
     * 
     * @param DataTableRequest $request
     * @return ResponseStatus
     */
    public function index(DataTableRequest $request)
    {
        try {
            $data = $this->foodService->fetch($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get All Food in Restaurant by ID
     * 
     * @param GetAllByRestaurantIdRequest $request
     * @return ResponseStatus
     */
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request) {
        try {
            $data = $this->foodService->getAllByRestaurantID($request);

            return ResponseStatus::response(['items' => new AllFoodCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get One Food
     * 
     * @param GetFoodRequest $request
     * @return ResponseStatus
     */
    public function show(GetFoodRequest $request) {
        try {
            $data = $this->foodService->find($request->id);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get Multiple Food
     * 
     * @param GetMultipleFood $request
     * @return ResponseStatus
     */
    public function showMultiple(GetMultipleFood $request) {
        try {
            $data = $this->foodService->findMany($request);

            return ResponseStatus::response(['items' => new AllFoodCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Add Food
     * 
     * @param AddFoodRequest $request
     * @return ResponseStatus
     */
    public function create(AddFoodRequest $request) {
        try {
            $data = $this->foodService->add($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Function to Update Food
     * 
     * @param UpdateFoodRequest $request
     * @return ResponseStatus
     */
    public function update(UpdateFoodRequest $request) {
        try {
            $data = $this->foodService->updates($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
    
    /**
     * Function to Get All Food in Restaurant by ID
     * 
     * @param DeleteFoodRequest $request
     * @return ResponseStatus
     */
    public function delete(DeleteFoodRequest $request) {
        try {
            $data = $this->foodService->deletes($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }
}
