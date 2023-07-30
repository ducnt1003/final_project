<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Direction;
use App\Models\Enroll;
use App\Repositories\Course\CourseRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecomendService extends BaseService
{
    public function recomend($id)
    {
        $directions = Direction::join('student_direction', 'directions.id', '=', 'student_direction.direction_id')
            ->where('student_direction.student_id', '=', $id)->get();
        $courses = Course::get()->toArray();
        $results = [];

        if (count($directions)>0) {
            foreach ($directions as $direction) {
                $rows = [];
                $rules = $direction->Rule->toArray();
                foreach ($rules as $rule) {
                    $row = array_map(function ($a) use ($rule) {
                        if ($a['level'] == $rule['level'] && $a['category_id'] == $rule['category_id'])
                            return 1;
                        return 0;
                    }, $courses);
                    if (count($rows) > 0) {
                        for ($i = 0; $i < count($row); $i++) {
                            $rows[$i] = $rows[$i] + $row[$i];
                        }
                    } else {
                        $rows = $row;
                    }
                }
                if (count($results) > 0) {
                    for ($i = 0; $i < count($row); $i++) {
                        $results[$i] = $results[$i] + $rows[$i];
                    }
                } else {
                    $results = $rows;
                }
            }
            // $magnitude = sqrt(array_sum($results));
            // $results = array_map(function ($element) use ($magnitude) {
            //     if ($magnitude == 0)
            //         return 0;
            //     return $element / $magnitude;
            // }, $results);
            $min = min($results);
            $max = max($results);
            $results = array_map(function ($element) use ($min, $max) {
                return ($element - $min) / ($max - $min);
            }, $results);
        } else {
            $results = array_map(function () {
                return 0;
            }, $courses);
        }

        $sim_csv_path = public_path("recommend/UserCourse_matrix.csv");
        $file = fopen($sim_csv_path, 'r');
        $datas = [];
        while (($data = fgetcsv($file, 0, ",")) !== FALSE) {
            $datas[] = $data;
        }
        $data = $datas[$id - 1];
        $enrolled = Enroll::join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where('student_id', $id)
            ->pluck("courses.id")
            ->toArray();
        // return $data;
        for ($i = 0; $i < count($results); $i++) {
            if (in_array(($i + 1), $enrolled)) {
                $results[$i] = 0;
            } else $results[$i] = 0.2* $results[$i] + (1 - 0.2) * $data[$i];
        }
        arsort($results);

        $newArray = array_slice($results, 0, 9, true);
        $array = array_map(function ($key, $value) {
            return [
                'id' => $key + 1,
                'course' => Course::find($key + 1)->name,
                'value' => number_format($value,3)
            ];
        }, array_keys($newArray), array_values($newArray));
        return $this->sendResponse($array, __('admin.message.success'));
        // return $array;
    }
}
