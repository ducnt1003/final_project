<?php

namespace App\Services;

use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\CoursePart;
use App\Repositories\Course\CourseRepository;
use Countable;
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
        $search = $request->search ? $request->search : null;
        $cate = $request->category_id ? $request->category_id : null;
        $teacher = $request->teacher ? $request->teacher : null;
        $per_page = $request->per_page ? $request->per_page : 9;
        $courses = $this->courseRepo->getList($search, $cate, $teacher, $per_page);
        return $this->sendResponse(new CourseCollection($courses), __('admin.message.success'));
    }

    public function getDetail($id) {

        $course = $this->courseRepo->find($id);
        if (!$course) {
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse(new CourseResource($course), __('admin.message.success'));
    }

    public function create($request) {
        $data = [
            'name' => $request->name,
            'description' => $request->description ?? '',
            'price' => $request->price ?? null,
            'level' => $request->level ?? null,
            'category_id' => $request->category ?? null,
            'teacher_id' => $request->teacher_id ?? null,
        ];

        $photo = $this->uploadService->uploadPhotoCourse($request);
        $data['photo'] = $photo;

        try {
            $data_parts = [];
            $course = $this->courseRepo->create($data);
            $index = 0;
            $parts = $request->parts ? json_decode('['.$request->parts.']', TRUE) : [];
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
        return $this->sendResponse(new CourseResource($course), __('admin.message.success'));
    }

    public function uploadDocument($id, $request) {
        $documents = $request->documents;
    }

    public function update($id, $request) {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'level' => $request->level,
            'category_id' => $request->category,
            'teacher_id' => $request->teacher_id,
        ];

        $photo = $this->uploadService->uploadPhotoCourse($request);
        if ($photo) $data['photo'] = $photo;
        // dd($data);
        try {
            $course = $this->courseRepo->update($id, $data);
            $index = 0;
            $parts = $request->parts ? json_decode('['.$request->parts.']', TRUE) : [];
            $course_parts = [];
            foreach($parts as $part) {
                $index ++;
                if (isset($part['id'])) {
                    $data_part = [
                        'course_id' => $id,
                        'part' => $index,
                        'name' => $part['name'],
                        'description' => $part['description'],
                    ];
                    $course_part = CoursePart::where('id', $part['id'])->update($data_part);
                    $course_parts[] = $part['id'];
                } else {
                    $data_part = [
                        'course_id' => $id,
                        'part' => $index,
                        'name' => $part['name'],
                        'description' => $part['description'],
                    ];
                    $course_part = CoursePart::create($data_part);
                    $course_parts[] = $course_part->id;
                }
            }
            CoursePart::whereNotIn('id', $course_parts)->delete();
        }catch (Exception $e) {
            Log::error($e);
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
