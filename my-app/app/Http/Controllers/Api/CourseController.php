<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * @var CourseService
     */
    protected CourseService $courseService;

    /**
     * @param CourseService $CourseService
     */
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function list(Request $request): JsonResponse
    {
        return $this->courseService->getList($request);
    }

    public function getDetail($id)
    {
        return $this->courseService->getDetail($id);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        return $this->courseService->create($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadDocument($id, Request $request): mixed
    {
        return $this->courseService->uploadDocument($id, $request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        return $this->courseService->update($id, $request);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        return $this->courseService->delete($id);
    }
}
