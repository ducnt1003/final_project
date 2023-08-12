<?php

namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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
        $search = $request->search ? $request->search : null;
        Log::info($request);
        $per_page = $request->itemsPerPage ? $request->itemsPerPage : 10;
        $categories = $this->categoryRepo->getList($search, $per_page);
        return $this->sendResponse(new CategoryCollection($categories), __('admin.message.success'));
    }

    public function getDetail($id) {
        $category = Category::find($id);
        return $this->sendResponse(new CategoryResource($category), __('admin.message.success'));
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

