<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Repositories\Course\CourseRepository;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService extends BaseService
{
    private UserRepository $userRepo;

    public function __construct(
        UserRepository $userRepo
    ) {
        $this->userRepo = $userRepo;
    }

    public function searchStudent($request) {
        $key = $request->search ?? '';
        $users = $this->userRepo->searchStudent($key);
        return $this->sendResponse($users, __('admin.message.success'));
    }

    public function list($request) {
        $search = $request->search ? $request->search : null;
        $mail = $request->mail ? $request->mail : null;
        $per_page = $request->itemsPerPage ? $request->itemsPerPage : 10;
        Log::info([$search, $mail]);
        $users = $this->userRepo->getList($search, $mail, $per_page);
        return $this->sendResponse(new UserCollection($users), __('admin.message.success'));
    }

    public function store($request) {
        
    }
}
