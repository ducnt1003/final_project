<?php

namespace App\Repositories\Direction;

use App\Models\Direction;
use App\Repositories\AbstractRepository;

class DirectionRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function model()
    {
        return Direction::class;
    }

    public function getList($per_page) {
        // if (!is_null($search))
            // return $this->model->where('name', 'LIKE', "%$search%")->get();
        return $this->model->paginate($per_page);
    }
}
