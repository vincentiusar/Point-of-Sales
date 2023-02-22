<?php

namespace App\Shareds;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    /**
     * Daftarkan relasi dari entity yang ingin digunakan
     *
     * @var array
     */
    protected $with = [];

    public function __construct(public Model $model)
    {
    }

    /**
     * Fungsi ini untuk mencari data berdasarkan ID
     *
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this->model->with($this->with)->findOrFail($id);
    }

    /**
     * Fungsi ini untuk menampilkan semua data
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->model->with($this->with)->get();
    }

    /**
     * Fungsi ini untuk menyimpan data baru
     *
     * @param Model $model
     * @return void
     * @throws \Throwable
     */
    public function create(Model $model): void
    {
        $model->saveOrFail();
    }

    /**
     * Fungsi ini untuk memperbaharui data
     *
     * @param Model $model
     * @return void
     * @throws \Throwable
     */
    public function update(Model $model): void
    {
        $model->updateOrFail();
    }

    /**
     * Fungsi ini untuk menghapus data
     *
     * @param int $id
     * @return void
     * @throws \Throwable
     */
    public function delete(int $id): void
    {
        $model = $this->model->findOrFail($id);
        $model->deleteOrFail();
    }

    /**
     * Fungsi ini untuk menghapus permanen data yang sudah terhapus
     *
     * @param integer $id
     * @return void
     */
    public function forceDelete(int $id): void
    {
        $model = $this->model->withTrashed()->findOrFail($id);
        $model->forceDelete();
    }

    /**
     * Fungsi ini untuk mengembalikan data yang sudah terhapus
     *
     * @param integer $id
     * @return void
     */
    public function restore(int $id): void
    {
        $model = $this->model->withTrashed()->findOrFail($id);
        $model->restore();
    }
}