<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function model()
    {
        return Category::class;
    }

    public function getList($search, $per_page) {
        if ($search)
            return $this->model->where('name', 'LIKE', "%$search%")->paginate($per_page);
        return $this->model->paginate($per_page);
    }
}
