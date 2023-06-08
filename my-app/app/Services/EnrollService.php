<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enroll;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EnrollService extends BaseService
{
    /**
     * @param BranchRepository $branchRepository
     */
    public function __construct()
    {
    }


    public function recommend($student)
    {
        $splited = $this->splitEnrolled($student);
        $enrolled = $splited['enrolled'];
        $non_enrolled = $splited['non_enrolled'];

        $scores = $this->calScore($enrolled, $non_enrolled);

        $scores['top_courses'] = Course::whereIn('courses.id', array_keys($scores['top_scores']))
            ->join('teachers', 'courses.teacher_id', '=', 'teachers.id')
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->leftJoin('enrolls', 'courses.id', '=', 'enrolls.course_id')
            ->groupby('courses.id')
            ->select([ 'courses.id', 'courses.name', 'courses.overview', 'courses.level', 'courses.thumbnail',
                'courses.rate', 'courses.teacher_id', 'courses.price', DB::raw('count(*) as enrolls'),
                'users.name as teacher_name',
            ])
            ->get();
        return $scores;
    }

    /**
     * Split course to 2 group: enrolled && non-enrolled
     */
    public function splitEnrolled($student)
    {
        $courses = Course::pluck("name", "id")->toArray();  // array(["id" =>"name"])
        $enrolled = Enroll::join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where('student_id', $student->id)
            ->pluck("courses.name", "courses.id")
            ->toArray();
        $non_enrolled = array_diff($courses, $enrolled);
        return [
            'enrolled' => $enrolled,
            'non_enrolled' => $non_enrolled
        ];
    }

    /**
     * Apply collaborative algorithm to get top score course_id
     */
    public function calScore($enrolled, $non_enrolled)
    {
        $sim_csv_path = public_path("recommend/similar_matrix.csv");
        $file = fopen($sim_csv_path, 'r');
        $row = fgetcsv($file, 0, ',');

        $index_2_id = Course::pluck("id")->toArray();
        $id_2_index = array_flip($index_2_id);

        $traces = [];
        $scores = array_fill_keys(array_keys($non_enrolled), 0);
        foreach ($non_enrolled as $c_i => $str_i) {
            # Find until get vector $c_i
            while ($row[0] != $str_i) {
                $row = fgetcsv($file, 0, ',');
            }

            $similar = array_fill_keys(array_keys($enrolled), 0);
            # Find maximun similar btw c_i vs each c_j of all enroleld course
            foreach (array_keys($enrolled) as $c_j) {
                $similar[$c_j] = $row[$id_2_index[$c_j] + 1];
            }
            arsort($similar);    # sort by value similar
            $courses_trace = [];
            foreach($similar as $key => $value) {
                $course_name = Course::where('id', $key)->first()->name;
                $courses_trace[$course_name] = $value;
            }
            // $traces[$c_i] = array_slice($courses_trace, 0, 3);
            $traces[$c_i] = $courses_trace;
            $scores[$c_i] = array_sum(array_slice($similar, 0, 3));
        }
        arsort($scores);
        // dd($scores);
        if (sizeof($scores) >= 3)
            $top_scores = array_slice($scores, 0, 3, true);
        else {
            $top_scores = $scores;
        }

        $traces = array_filter($traces, function ($key) use ($top_scores) {
            return in_array($key, array_keys($top_scores));
        }, ARRAY_FILTER_USE_KEY);

        return [
            'top_scores' => $top_scores,
            'traces' => $traces
        ];
    }

}
