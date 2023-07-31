<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\RecomendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecomendController extends Controller
{

    protected RecomendService $recomendService;
    /**
     * @param RecomendService $recomendService
     */
    public function __construct(RecomendService $recomendService)
    {
        $this->recomendService = $recomendService;
    }

    public function recomend($id) {
        return $this->recomendService->recomend($id);
    }

    public function getData() {
        // return (1);
        $path = public_path("recommend/mooc.test.rating");
        $myfile = fopen($path, 'r');
        $arr = [];
        $count = 0;
        while(!feof($myfile)) {
            $b = [];
            $a = fgets($myfile);
            if (empty($a)){
                break;
            }
            $a = str_replace("\r\n", "",$a);
            $b = explode("\t",$a);
            if ($b[1] < 100 && $b[0] < 2000) {
                $arr[] = $b;
            }
        }
        return count($arr);
        fclose($myfile);
    }

    public function test() {
        $file = fopen(public_path('recommend/enroll_test.csv'), 'r');
        $row = fgetcsv($file, 0, ','); # ignore first row
        $arr = [];
        $count = 0;
        while (($row = fgetcsv($file, 0, ',')) !== false) {
            $course = DB::table('courses')
                ->where('name', $row[5])
                ->first();
            if ($course) {
                $course_id = $course->id;
            } else {
                continue;
            }
            $student_id = DB::table('users')->where('name', $row[4])
                ->join('students', 'users.id', '=', 'students.user_id')
                ->select(['students.id as id', ])
                ->first()->id;
            if (!isset($arr[$student_id-1])) {
                $arr[$student_id-1] = [$course_id];
            } else array_push($arr[$student_id-1], $course_id);

        }
        fclose($file);
        ksort($arr);

        $file_train = fopen(public_path('recommend/UserCourse_matrix.csv'), 'r');
        // $row_train = fgetcsv($file_train, 0, ','); # ignore first row
        $trains = [];
        $count = 0;
        while (($row_train = fgetcsv($file_train, 0, ',')) !== false) {
            $trains[$count] = $row_train;
            $count++;
        }
        fclose($file_train);


        // return $trains;
        $results = [];
        for ($k = 3 ; $k < 11; $k++) {
            // Log::info($thres);
            $pre = 0;
            $recall = 0;
            foreach($arr as $index => $test) {
                $i = 0;
                $train_data = [];
                foreach($trains[$index] as $train) {
                    if ($train != 1) {
                        $train_data[$i] = $train;
                    }
                    $i++;
                }
                // $train = array_filter($trains[$index], function ($k) use($i) {
                //     $i++;
                //     return  $k != 1;
                // });
                arsort($train_data);
                Log::info($train_data);
                $top = array_keys($train_data);
                $actualy = array_slice($top, 0, $k);

                // $actualy = array_keys($top);
                $hit = array_intersect($test, $actualy);
                // Log::info([$actualy, $test, $hit] );
                $recall = $recall + count($hit)/count($test);
                $pre = $pre + count($hit)/count($actualy);
            }
            $n = count($arr);
            $results[] = [$pre/$n,$recall/$n];
        }
        return $results;
    }
}
