<?php

namespace App\Services;

use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\CoursePart;
use App\Repositories\Course\CourseRepository;
use Countable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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
        $const_per_page = 9;
        if (Auth::user() && Auth::user()->role_id != 0) {
            $const_per_page = 10;
        }
        $search = $request->search ? $request->search : null;
        $cate = $request->category ? $request->category : null;
        $teacher = $request->teacher ? $request->teacher : null;
        $per_page = $request->itemsPerPage ? $request->itemsPerPage : $const_per_page;
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
            $cours_part_old = CoursePart::where('course_id', $id)->get()->toArray();
            $cours_parts_old = array_map(function ($e) {
                return $e['id'];
            }, $cours_part_old);
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
                    // $course_parts[] = $course_part->id;
                }
            }
            $course_delete = array_diff($cours_parts_old, $course_parts);
            CoursePart::whereIn('id', $course_delete)->delete();
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
