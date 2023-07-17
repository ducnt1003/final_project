<?php

namespace App\Services;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\JsonResponse;

class CategoryService extends BaseService
{

    private CategoryRepository $categoryRepo;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    public function getList($request) {
        $search = $request->search ?? null;
        $categories = $this->categoryRepo->getList($search);
        return $this->sendResponse($categories, __('admin.message.success'));
    }

    public function create($request) {
        $data = [
            'name' => $request->name,
            'description' => $request->description ?? null,
            'photo' => $request->photo ?? null,
        ];

        $category = $this->categoryRepo->create($data);
        if (!$category) {
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse($category, __('admin.message.success'));
    }

    public function update($id, $request) {
        $data = [];

        if ($request->name) $data['name'] = $request->name;
        if ($request->description) $data['description'] = $request->description;
        if ($request->photo) $data['photo'] = $request->photo;
        
        $category = $this->categoryRepo->update($id, $data);
        if (!$category) {
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse($category, __('admin.message.success'));
    }

    public function delete($id): JsonResponse
    {
        if ($this->categoryRepo->delete($id))
            return $this->sendResponse(null, __('admin.message.success'));
        return $this->sendError(null, __('admin.message.error'));
    }


}

