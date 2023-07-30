<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RecomendService;
use Illuminate\Http\Request;
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
}
