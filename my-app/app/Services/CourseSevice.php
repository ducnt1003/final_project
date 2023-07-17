<?php

namespace App\Services;

use App\Repositories\Course\CourseRepository;
use Illuminate\Http\JsonResponse;

class CourseService extends BaseService
{
    private CourseRepository $courseRepo;

    /**
     * @param CourseRepository $CourseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepo = $courseRepository;
    }

    public function create($request) {
        $data = [
            'name' => $request->name,
            'description' => $request->description ?? null,
            'photo' => $request->photo ?? null,
            'price' => $request->price ?? null,
            'level' => $request->level ?? null,
            'category_id' => $request->category_id ?? null,
            'teacher_id' => $request->teacher_id ?? null,
        ];

        $course = $this->courseRepo->create($data);
        if (!$course) {
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse($course, __('admin.message.success'));
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
