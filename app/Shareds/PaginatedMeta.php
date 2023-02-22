<?php

namespace App\Shareds;

class PaginatedMeta
{
    public function __construct(
        public int $page,
        public int $perPage,
        public int $total,
        public int $totalPage,
    ) {}
}
