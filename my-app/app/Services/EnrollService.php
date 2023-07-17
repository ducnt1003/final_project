<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enroll;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnrollService extends BaseService
{
    CONST k = 3;
    /**
     * @param BranchRepository $branchRepository
     */
    public function __construct()
    {
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

    public function dumpCSV()
    {
        $students = Student::join('users', 'students.user_id', '=', 'users.id')
            ->pluck("users.name", "students.id")
            ->toArray();  // array(["id" =>"name"])
        $courses = Course::pluck("name", "id")->toArray();
        $enrolls = Enroll::select('student_id', 'course_id')->get();
        Log::info($enrolls);
        # ----------------------------------------------------------------- #
        # Save csv enrollment data
        // $enroll_matrix_csv = "student,".implode(",", array_values($courses))."\n";
        $courses_vector = array();

        foreach (array_keys($students) as $student_id) {
            # Assign row[enrolled items] to 1
            $row = array(); // vector users (1, 0, ...)
            foreach (array_keys($courses) as $course_id) {
                $enroll = $enrolls->where(['student_id' => $student_id, 'course_id' => $course_id,]);
                $row[$course_id] = $enroll ? 1 : 0;
            }
            Log::info(2);

            # Normalize by magnitude
            // $magnitude = sqrt(array_sum($row));
            // $row = array_map(function ($element) use ($magnitude) {
            //     if ($magnitude == 0)
            //         return 0;
            //     return $element / $magnitude;
            // }, $row);

            # Save vector to calculate similar
            array_push($courses_vector, $row);
            // $enroll_matrix_csv .= $students[$student_id].",".implode(",", $row)."\n";
        }
        Log::info($courses_vector);
        // $filePath = public_path("recommend/enroll_matrix.csv");
        // $this->saveCSV($filePath, $enroll_matrix_csv);

        # ----------------------------------------------------------------- #
        # Save csv course similar matrix by enrollment data
        // $similarE_matrix_csv = "course,".implode(",", array_values($courses))."\n";
        // foreach (array_keys($courses) as $c_i) {
        //     $row = array();
        //     foreach (array_keys($courses) as $c_j) {
        //         $c_i_vector = array_column($courses_vector, $c_i);
        //         $c_j_vector = array_column($courses_vector, $c_j);
        //         if ($c_i == $c_j)
        //             $row[$c_j] = 1;
        //         else $row[$c_j] = $this->calCosineSimilar($c_i_vector, $c_j_vector);
        //     }
        //     $similarE_matrix_csv .= $courses[$c_i].",".implode(",", $row)."\n";
        // }

        // $filePath = public_path("recommend/similarE_matrix.csv");
        // $this->saveCSV($filePath, $similarE_matrix_csv);

        return 1;
        // return $this->response();
    }

    /**
     * Calculate CosineSimilar from 2 vector u, v
     */
    public function calCosineSimilar($u, $v)
    {
        $dot_product = array_sum(array_map( function ($u_i, $v_i) {
            return $u_i * $v_i;
        }, $u, $v));

        $u_val = sqrt(
            array_sum(array_map( function ($u_i, $u_I) {
                return $u_i * $u_I;
            }, $u, $u))
        );

        $v_val = sqrt(
            array_sum(array_map( function ($v_i, $v_I) {
                return $v_i * $v_I;
            }, $v, $v))
        );

        if($u_val == 0 || $v_val == 0)
            return 0;

        return $dot_product / ($u_val * $v_val);
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
        fwrite($fp, $csv);
        fclose($fp);
    }

}
