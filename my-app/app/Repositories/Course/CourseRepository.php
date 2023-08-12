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

    public function getList($search,$cate, $teacher, $per_page) {
        // if (!is_null($search))
            // return $this->model->where('name', 'LIKE', "%$search%")->get();
        $result = $this->model->select('courses.*');
        if ($teacher) {
            $result = $result->join('teachers', 'teachers.id', '=', 'courses.teacher_id')
                ->join('users', 'users.id', '=', 'teachers.user_id')
                ->where('users.name', 'LIKE', "%$teacher%");
        }
        if ($search) {
            $result = $result->where('courses.name', 'LIKE', "%$search%");
        }
        if ($cate) {
            $result = $result->where('category_id', $cate);
        }

        return $result->paginate($per_page);
    }
}
