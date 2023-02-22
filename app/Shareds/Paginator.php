<?php

namespace App\Shareds;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Shareds\PaginatedMeta;

class Paginator
{
    public array $items;
    public PaginatedMeta $meta;

    public function __construct($items, $meta)
    {
        $this->items = $items;
        $this->meta = $meta;
    }

    /**
     * Build pagination response meta
     *
     * @param LengthAwarePaginator $paginator
     * @return static
     */
    public static function fromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            $paginator->items(),
            new PaginatedMeta(
                $paginator->currentPage(),
                $paginator->perPage(),
                $paginator->total(),
                $paginator->lastPage()
            ),
        );
    }

    /**
     * Set config pagination data
     *
     * @param $query
     * @param int|null $page
     * @param int|null $perPage
     * @return Paginator
     */
    public static function paginate($query, ?int $page = 1, ?int $perPage = 10): Paginator
    {
        $perPage = $perPage ?? 10;
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return self::fromPaginator($data);
    }
}