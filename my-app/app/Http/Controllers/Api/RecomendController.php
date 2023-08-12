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
        ini_set('max_execution_time', 800);
    }

    public function recomend($id)
    {
        return $this->recomendService->recomend($id);
    }

    public function getConfig()
    {
        return $this->recomendService->getConfig();
    }

    public function getData()
    {
        // return (1);
        $path = public_path("recommend/mooc.train.rating");
        $myfile = fopen($path, 'r');
        $arr = [];
        $count = 0;
        $num_user = 5000;
        $num_course = 50;
        $matrix = [];
        $finals = [];
        for ($i = 0; $i < $num_user; $i++) {
            $sample = array_fill(0, $num_course, 0);
            $matrix[] = $sample;
            $finals[] = $sample;
        }
        while (!feof($myfile)) {
            $b = [];
            $a = fgets($myfile);
            if (empty($a)) {
                break;
            }
            $a = str_replace("\r\n", "", $a);
            $b = explode("\t", $a);
            if ($b[1] < $num_course && $b[0] < $num_user) {
                $matrix[$b[0]][$b[1]] = 1;
                // Log::info($b[1]);
            }
        }
        fclose($myfile);

        foreach ($matrix as $row) {
            $magnitude = sqrt(array_sum($row));
            $row = array_map(function ($element) use ($magnitude) {
                if ($magnitude == 0)
                    return 0;
                return $element / $magnitude;
            }, $row);
            $matrix_nor[] = $row;
        }

        // Log::info($matrix_nor);

        $similar = [];
        for ($i = 0; $i < $num_course; $i++) {
            $row = [];
            for ($j = 0; $j < $num_course; $j++) {
                $c_i = array_column($matrix_nor, $i);
                $c_j = array_column($matrix_nor, $j);
                if ($i == $j)
                    $row[$j] = 1;
                else $row[$j] = $this->calCosineSimilar($c_i, $c_j);
            }
            $similar[] = $row;
        }

        $u = 0;
        foreach ($matrix as $final) {
            $row = array_filter($final, function ($a) {
                return $a == 1;
            });
            $un_row = array_filter($final, function ($a) {
                return $a != 1;
            });
            $keys = array_keys($row);
            $un_keys = array_keys($un_row);
            foreach ($un_keys as $un) {
                $row = $similar[$un];
                $row[$un] = 0;
                arsort($row);
                $top = array_slice($row, 0, 5);
                $finals[$u][$un] = array_sum($top) / 5;
            }
            $u++;
        }

        $filePath = public_path("recommend/train_matrix.csv");
        $this->saveCSV($filePath, $finals);

        return 1;
    }

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

    public function test()
    {
        $path = public_path("recommend/mooc.test.rating");
        $myfile = fopen($path, 'r');
        $num_user = 5000;
        $num_course = 50;
        $matrix = [];
        // for ($i = 0 ; $i<$num_user ; $i++) {
        //     $sample = array_fill(0, $num_course, 0);
        //     $matrix[] = $sample;
        // }
        while (!feof($myfile)) {
            $b = [];
            $a = fgets($myfile);
            if (empty($a)) {
                break;
            }
            $a = str_replace("\r\n", "", $a);
            $b = explode("\t", $a);
            if ($b[1] < $num_course && $b[0] < $num_user) {
                $matrix[$b[0]][] = $b[1];
                // Log::info($b[1]);
            }
        }
        fclose($myfile);
        $file_train = fopen(public_path('recommend/train_matrix.csv'), 'r');
        $trains = [];
        $count = 0;
        while (($row_train = fgetcsv($file_train, 0, ',')) !== false) {
            $trains[$count] = $row_train;
            $count++;
        }
        fclose($file_train);
        $results = [];
        for ($k = 1; $k < 10; $k++) {
            $precision = 0;
            $recall = 0;
            foreach ($matrix as $index => $actualy) {
                $row = $trains[$index];
                arsort($row);
                $key = array_keys($row);
                $recomend = array_slice($key, 0, $k);
                $hit = array_intersect($recomend, $actualy);
                $recall = $recall + count($hit) / count($actualy);
                $precision = $precision + count($hit) / count($recomend);
            }
            $n = count($matrix);
            $results[] = [$recall / $n, 2*$precision / $n, $k];
        }
        return $results;
        return array_sum(array_column($results,0))/30;
    }

    public function test1()
    {
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
                ->select(['students.id as id',])
                ->first()->id;
            if (!isset($arr[$student_id - 1])) {
                $arr[$student_id - 1] = [$course_id];
            } else array_push($arr[$student_id - 1], $course_id);
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
        for ($k = 3; $k < 11; $k++) {
            // Log::info($thres);
            $pre = 0;
            $recall = 0;
            foreach ($arr as $index => $test) {
                $i = 0;
                $train_data = [];
                foreach ($trains[$index] as $train) {
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
                $recall = $recall + count($hit) / count($test);
                $pre = $pre + count($hit) / count($actualy);
            }
            $n = count($arr);
            $results[] = [$pre / $n, $recall / $n];
        }
        return $results;
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

    public function changeConfig(Request $request) {
        return $this->recomendService->changeConfig($request);
    }
}
