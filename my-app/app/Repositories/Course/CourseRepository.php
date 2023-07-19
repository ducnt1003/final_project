<?php

namespace App\Repositories\Course;

use App\Models\Course;
use App\Repositories\AbstractRepository;

class CourseRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function model()
    {
        return Course::class;
    }

    public function getList($search) {
        // if (!is_null($search))
            // return $this->model->where('name', 'LIKE', "%$search%")->get();
        return $this->model->get();
    }
}
