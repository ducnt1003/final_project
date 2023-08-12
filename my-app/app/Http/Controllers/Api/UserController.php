<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function searchStudent(Request $request) {
        return $this->userService->searchStudent($request);
    }

    public function list(Request $request) {
        return $this->userService->list($request);
    }

    public function store(Request $request) {
        return $this->userService->store($request);
    }
}
