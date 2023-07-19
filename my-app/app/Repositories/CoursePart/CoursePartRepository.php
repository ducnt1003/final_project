<?php

namespace App\Repositories\CoursePart;

use App\Repositories\AbstractRepository;

class CoursePartRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function model()
    {
        return CoursePart::class;
    }
}