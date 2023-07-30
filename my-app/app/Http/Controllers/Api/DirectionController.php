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

    public function list() {
        return $this->directionService->getList();
    }
}
