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

    public function getList($search) {
        if (!is_null($search))
            return $this->model->where('name', 'LIKE', "%$search%")->get();
        return $this->model->get();
    }
}