<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\EnrollRepository;
use App\Models\Student;
use App\Models\Course;
use App\Models\Direction;
use App\Models\Enroll;
use App\Models\User;
use App\Services\EnrollService;
use Illuminate\Support\Facades\Log;

class EnrollController extends Controller
{
    protected $service;

    public function __construct(EnrollService $enrollService)
    {
        $this->service = $enrollService;
        ini_set('max_execution_time', 300);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $this->response($this->entity->pageWithRequest($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function isEnrolled(Request $request) {
        return $this->service->isEnrolled($request);
    }

    public function enroll(Request $request) {
        return $this->service->enroll($request);
    }

    public function dump_csv()
    {
        ini_set('max_execution_time', 500);
        $students = Student::join('users', 'students.user_id', '=', 'users.id')
            ->pluck("users.name", "students.id")
            ->toArray();  // array(["id" =>"name"])
        $courses = Course::pluck("name", "id")->toArray();

        # ----------------------------------------------------------------- #
        # Save csv enrollment data
        $enroll_matrix_csv = "student," . implode(",", array_values($courses)) . "\n";
        $courses_vector = array();

        foreach (array_keys($students) as $student_id) {
            # Assign row[enrolled items] to 1
            $row = array(); // vector users (1, 0, ...)
            foreach (array_keys($courses) as $course_id) {
                $enroll = Enroll::where(['student_id' => $student_id, 'course_id' => $course_id,])->first();
                $row[$course_id] = $enroll ? 1 : 0;
            }

            # Normalize by magnitude
            $magnitude = sqrt(array_sum($row));
            $row = array_map(function ($element) use ($magnitude) {
                if ($magnitude == 0)
                    return 0;
                return $element / $magnitude;
            }, $row);

            # Save vector to calculate similar
            array_push($courses_vector, $row);
            $enroll_matrix_csv .= $students[$student_id] . "," . implode(",", $row) . "\n";
        }
        $filePath = public_path("recommend/enroll_matrix.csv");
        $similarE_matrix_csv = "course," . implode(",", array_values($courses)) . "\n";
        $similar = [];
        foreach (array_keys($courses) as $c_i) {
            $row = array();
            foreach (array_keys($courses) as $c_j) {
                $c_i_vector = array_column($courses_vector, $c_i);
                $c_j_vector = array_column($courses_vector, $c_j);
                if ($c_i == $c_j)
                    $row[$c_j] = 1;
                else $row[$c_j] = $this->calCosineSimilar($c_i_vector, $c_j_vector);
            }
            array_push($similar, $row);
            $similarE_matrix_csv .= $courses[$c_i] . "," . implode(",", $row) . "\n";
        }

        $filePath = public_path("recommend/similarE_matrix1.csv");
        $this->saveCSV($filePath, $similar);

        // $this->saveCSV($filePath, $enroll_matrix_csv);
        return $similar;
        // return $this->service->dumpCsv();
    }

    /**
     *
     */
    public function saveCSV($filePath, $csv)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $fp = fopen($filePath, "w+");
        foreach ($csv as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }

    public function calCosineSimilar($u, $v)
    {
        $dot_product = array_sum(array_map(function ($u_i, $v_i) {
            return $u_i * $v_i;
        }, $u, $v));

        $u_val = sqrt(
            array_sum(array_map(function ($u_i, $u_I) {
                return $u_i * $u_I;
            }, $u, $u))
        );

        $v_val = sqrt(
            array_sum(array_map(function ($v_i, $v_I) {
                return $v_i * $v_I;
            }, $v, $v))
        );

        if ($u_val == 0 || $v_val == 0)
            return 0;

        return $dot_product / ($u_val * $v_val);
    }

    public function calculateUserScore()
    {
        $sim_csv_path = public_path("recommend/similarE_matrix1.csv");
        $file = fopen($sim_csv_path, 'r');
        $row = [];
        while (($data = fgetcsv($file, 0, ",")) !== FALSE) {
            $row[] = $data;
        }
        $students = Student::get();
        $courses = Course::get();
        $results = [];
        foreach ($students as $student) {
            $result = [];
            foreach ($courses as $course) {
                $score = $this->calScore($student, $course->id, $row);
                array_push($result, $score);
            }
            array_push($results, $result);
        }

        $filePath = public_path("recommend/UserCourse_matrix.csv");
        $this->saveCSV($filePath, $results);

        return 1;
    }

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

    public function calScore($student, $course_id, $row)
    {
        $enrolled = Enroll::where('student_id', '=', $student->id)->where('course_id', $course_id)->first();
        if ($enrolled) return 1;
        $course_similar = $row[$course_id - 1];
        arsort($course_similar);
        $top = array_slice($course_similar, 1, 6);
        return array_sum($top) / 5;
    }

    public function recomend($id)
    {
        $directions = Direction::join('student_direction', 'directions.id', '=', 'student_direction.direction_id')
            ->where('student_direction.student_id', '=', $id)->get();
        $courses = Course::get()->toArray();
        $results = [];
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
        $magnitude = sqrt(array_sum($results));
        $results = array_map(function ($element) use ($magnitude) {
            if ($magnitude == 0)
                return 0;
            return $element / $magnitude;
        }, $results);

        $sim_csv_path = public_path("recommend/UserCourse_matrix.csv");
        $file = fopen($sim_csv_path, 'r');
        $datas = [];
        while (($data = fgetcsv($file, 0, ",")) !== FALSE) {
            $datas[] = $data;

        }

        $data = $datas[$id-1];
        $enrolled = Enroll::join('courses', 'enrolls.course_id', '=', 'courses.id')
            ->where('student_id', $id)
            ->pluck("courses.id")
            ->toArray();
            Log::info($enrolled);
        for ($i = 0; $i < count($results); $i++) {
            if (in_array(($i+1), $enrolled)) {
                $results[$i] = 0;
            } else $results[$i] = 0.5*$results[$i] + (1-0.5)*$data[$i];
        }
        arsort($results);
        return $results;
    }
}
