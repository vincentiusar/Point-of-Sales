<?php

namespace App\Services\Table\impl;

use App\Http\Requests\DataTableRequest;
use App\Http\Requests\Table\AddTableRequest;
use App\Http\Requests\Table\DeleteTableRequest;
use App\Http\Requests\Table\GetAllByRestaurantIdRequest;
use App\Http\Requests\Table\UpdateTableRequest;
use App\Models\Table;
use App\Services\Table\TableService;
use App\Shareds\BaseService;
use App\Shareds\Paginator;

class TableServiceImpl extends BaseService implements TableService
{

    const ALLOW_TO_SORT_AND_SEARCH = [
        'status',
    ];

    public function __construct(
        private Table $table,
    )
    {
        parent::__construct($table);
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

        $queryData = $this->table
                    ->with(
                        [
                            'restaurant' => function ($query) {
                                return $query->select(['id', 'name', 'description', 'address']);
                            }
                        ]
                    )
                    ->select([
                        'id',
                        'status',
                        'session_id',
                        'restaurant_id'
                    ])
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->search%");
                    })
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function getAllByRestaurantID(GetAllByRestaurantIdRequest $request) {
        $order = getValueOrDefault($request->order, ['desc', 'asc'], 'desc');
        $sort = getValueOrDefault($request->sort, self::ALLOW_TO_SORT_AND_SEARCH, 'id');

        $queryData = $this->table
                    ->select([
                        'id',
                        'status',
                        'session_id',
                        'restaurant_id'
                    ])
                    ->where('restaurant_id', $request->restaurant_id)
                    ->when($request->search, function ($query) use ($request) {
                        $query->where('name', 'like', "%$request->search%");
                    })
                    ->orderBy($sort, $order);
        
        return Paginator::paginate($queryData, $request->page, $request->per_page);
    }

    public function find(int $id) {
        return $this->findById($id);
    }

    public function add(AddTableRequest $request) {
        $table = 
            [
                'restaurant_id' => $request['restaurant_id'],
                'status' => 'open',
            ];
        $data = $this->table->create($table);

        return $data;
    }

    public function updates(UpdateTableRequest $request) {
        $table = $this->find($request->table_id);
        $table->update($request->all());

        return $table;
    }

    public function deletes(DeleteTableRequest $request) {
        $table = $this->find($request->id);
        $table->delete($request->id);

        return $table;
    }
}