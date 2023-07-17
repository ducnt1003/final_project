<?php

namespace App\Services;

use App\Repositories\Course\CourseRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseService extends BaseService
{
    private CourseRepository $courseRepo;
    private UploadService $uploadService;

    /**
     * @param CourseRepository $CourseRepository
     */
    public function __construct(
        CourseRepository $courseRepository, 
        UploadService $uploadService
        )
    {
        $this->courseRepo = $courseRepository;
        $this->uploadService = $uploadService; 
    }

    public function getList($request) {
        $search = $request->search ?? null;
        $courses = $this->courseRepo->getList($search);
        return $this->sendResponse($courses, __('admin.message.success'));
    }

    public function create($request) {
        $data = [
            'name' => $request->name,
            'description' => $request->description ?? null,
            'price' => $request->price ?? null,
            'level' => $request->level ?? null,
            'category_id' => $request->category_id ?? null,
            'teacher_id' => $request->teacher_id ?? null,
        ];
        
        $photo = $this->uploadService->uploadPhotoCourse($request);
        $data['photo'] = $photo;
        $parts = $request->parts ?? [];

        try {
            $data_parts = [];
            $course = $this->courseRepo->create($data);
            $index = 0;
            $parts = $request->parts ? json_decode($request->parts, TRUE) : [];
            // $parts = json_decode($your_json_string, TRUE);
            foreach($parts as $part) {
                $index ++;
                $data_parts[] = [
                    'course_id' => $course->id,
                    'part' => $index,
                    'name' => $part['name'],
                    'description' => isset($part['description']) ? $part['description'] : null ,
                ];
            }
            DB::table('course_parts')->insert($data_parts);

        }catch (Exception $e) {
            Log::error($e);
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse($course, __('admin.message.success'));
    }

    public function uploadDocument($request) {
        
    }

    public function update($id, $request) {
        $data = [];

        if ($request->name) $data['name'] = $request->name;
        if ($request->description) $data['description'] = $request->description;
        if ($request->photo) $data['photo'] = $request->photo;
        if ($request->price) $data['price'] = $request->price;
        if ($request->level) $data['level'] = $request->level;
        if ($request->category_id) $data['category_id'] = $request->category_id;
        if ($request->teacher_id) $data['teacher_id'] = $request->teacher_id;
        
        $course = $this->courseRepo->update($id, $data);
        if (!$course) {
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse($course, __('admin.message.success'));
    }

    public function delete($id): JsonResponse
    {
        if ($this->courseRepo->delete($id))
            return $this->sendResponse(null, __('admin.message.success'));
        return $this->sendError(null, __('admin.message.error'));
    }
}