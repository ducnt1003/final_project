<?php

namespace App\Services;

use App\Repositories\Direction\DirectionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DirectionService extends BaseService
{
    private DirectionRepository $directionRepo;

    public function __construct(DirectionRepository $directionRepository)
    {
        $this->directionRepo = $directionRepository;
    }

    public function getList() {
        $directions = $this->directionRepo->getList();
        return $this->sendResponse($directions, __('admin.message.success'));
    }

}
