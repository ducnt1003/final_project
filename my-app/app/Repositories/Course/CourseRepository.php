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
}