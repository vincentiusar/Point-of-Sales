<?php

namespace App\Http\Controllers\Table;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Table\AddTableRequest;
use App\Http\Requests\Table\DeleteTableRequest;
use App\Http\Requests\Table\GetAllByRestaurantIdRequest;
use App\Http\Requests\Table\GetTableRequest;
use App\Http\Requests\Table\UpdateRestaurant;
use App\Http\Requests\Table\UpdateTableRequest;
use App\Http\Resources\Table\AllTableCollection;
use App\Http\Resources\Table\DetailResource;
use App\Http\Resources\Table\IndexCollection;
use App\Services\Table\TableService;
use App\Shareds\ResponseStatus;
use Error;
use Illuminate\Http\Request;

class TableController extends Controller
{
    
    public function __construct(
        private TableService $tableService,
    )
    {
    }

    /**
     * Function to Get All Table
     * 
     * @param DataTableRequest $request
     * @return ResponseStatus
     */
    public function index(DataTableRequest $request) {
        try {
            $data = $this->tableService->fetch($request);

            return ResponseStatus::response(['items' => new IndexCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get All Table in Restaurant by ID
     * 
     * @param GetAllByRestaurantIdRequest $request
     * @return ResponseStatus
     */
    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request) {
        try {
            $data = $this->tableService->getAllByRestaurantID($request);

            return ResponseStatus::response(['items' => new AllTableCollection($data->items), 'meta' => $data->meta]);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get One Table by ID
     * 
     * @param GetTableRequest $request
     * @return ResponseStatus
     */
    public function show(GetTableRequest $request) {
        try {
            $data = $this->tableService->find((int) $request->id);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Get One Table by ID
     * 
     * @param AddTableRequest $request
     * @return ResponseStatus
     */
    public function create(AddTableRequest $request) {
        try {
            $data = $this->tableService->add($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Update One Table by ID
     * 
     * @param UpdateTableRequest $request
     * @return ResponseStatus
     */
    public function update(UpdateTableRequest $request) {
        try {
            $data = $this->tableService->updates($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to Update One Table by ID
     * 
     * @param DeleteTableRequest $request
     * @return ResponseStatus
     */
    public function delete(DeleteTableRequest $request) {
        try {
            $data = $this->tableService->deletes($request);

            return ResponseStatus::response(new DetailResource($data));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

}
