<?php

namespace App\Services;


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
}
