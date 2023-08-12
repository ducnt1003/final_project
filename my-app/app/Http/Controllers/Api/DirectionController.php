<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DirectionService;
use Illuminate\Http\Request;

class DirectionController extends Controller
{
    protected DirectionService $directionService;

    public function __construct(DirectionService $directionService)
    {
        $this->directionService = $directionService;
    }

    public function list(Request $request) {
        return $this->directionService->getList($request);
    }

    public function getDetail($id) {
        return $this->directionService->getDetail($id);
    }

    public function select(Request $request) {
        return $this->directionService->select($request);
    }

    public function selected(Request $request) {
        return $this->directionService->selected($request);
    }

    public function create(Request $request) {
        return $this->directionService->create($request);
    }

    public function update($id, Request $request)
    {
        return $this->directionService->update($id, $request);
    }
}
