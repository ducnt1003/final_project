<?php

namespace App\Services;

use App\Http\Resources\CourseResource;
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
    public function getConfig() {
        $config = DB::table('configs')->first();
        return $config;
    }
    public function recomend($id)
    {
        $config = DB::table('configs')->first();
        $k = $config->value;
        $directions = Direction::select('directions.*')->join('student_direction', 'directions.id', '=', 'student_direction.direction_id')
            ->where('student_direction.student_id', '=', $id)->get();
        $courses = Course::get()->toArray();
        $results = [];
        if (count($directions) > 0) {
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

        if (count($datas) + 1 <= (int)$id) {
            $data = [];
        } else {
            $data = $datas[$id - 1];

        }
        Log::info(1);
        $enrolled = Enroll::join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where('student_id', $id)
            ->pluck("courses.id")
            ->toArray();
        // return $data;
        for ($i = 0; $i < count($results); $i++) {
            if (in_array(($i + 1), $enrolled)) {
                $results[$i] = 0;
            } else if (count($data) > 0) {
                $results[$i] = (1-$k) * $results[$i] + $k * $data[$i];
            } else {
                $results[$i] = (1-$k) * $results[$i];
            }

        }
        arsort($results);

        $newArray = array_slice($results, 0, 9, true);
        $array = array_map(function ($key, $value) {
            return [
                'id' => $key + 1,
                'course' => new CourseResource(Course::find($key + 1)),
                'value' => number_format($value, 3)
            ];
        }, array_keys($newArray), array_values($newArray));
        return $this->sendResponse($array, __('admin.message.success'));
        // return $array;
    }

    public function changeConfig($request)
    {
        $config = $request->config;
        $old_config = DB::table('configs')->first();
        DB::table('configs')->where('id', $old_config->id)->delete();
        DB::table('configs')->insert(['value' => $config]);
        return $this->sendResponse(null, __('admin.message.success'));
    }
}
