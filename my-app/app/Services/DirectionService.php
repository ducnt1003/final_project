<?php

namespace App\Services;

use App\Models\DirectionRule;
use App\Models\Expert;
use App\Models\Student;
use App\Repositories\Direction\DirectionRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

    public function select($request) {
        $direction_select = $request->directions ? $request->directions : [];
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        $directions = DB::table('student_direction')->where('student_id', $student->id)->pluck('direction_id')->toArray();
        $selected = array_intersect($direction_select, $directions);

        try {
            foreach ($directions as $de) {
                if (!in_array($de, $selected)) {
                    DB::table('student_direction')->where('student_id', $student->id)->where('direction_id', $de)->delete();
                }
            }
            foreach ($direction_select as $in) {
                if (!in_array($in, $selected)) {
                    DB::table('student_direction')->insert([
                        'direction_id' => $in,
                        'student_id' => $student->id
                    ]);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse(null, __('admin.message.success'));
    }

    public function create($request) {
        $user = Auth::user();
        $expert = Expert::where('user_id', $user->id)->first();
        $data = [
            'name' => $request->name,
            'description' => $request->description ?? '',
            'expert_id' => $expert->id
        ];

        try {
            $direction = $this->directionRepo->create($data);
            $rules = $request->rules ? json_decode('['.$request->rules.']', TRUE) : [];
            $data_rules = [];
            foreach ($rules as $rule) {
                $data_rule = [
                    'direction_id' => $direction->id,
                    'category_id' => $rule['category'],
                    'level' => $rule['level']
                ];
                $data_rules[] = $data_rule;
            }
            DB::table('direction_rule')->insert($data_rules);
        } catch (Exception $e) {
            Log::error($e);
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse(null, __('admin.message.success'));
    }

    public function update($id, $request) {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'expert_id' => $request->expert_id,
        ];

        try {
            $direction = $this->directionRepo->update($id, $data);
            $rules = $request->rules ? json_decode('['.$request->rules.']', TRUE) : [];
            $data_rules = [];
            foreach ($rules as $rule) {
                if (isset($rule['id'])) {
                    $data_rule = [
                        'direction_id' => $direction->id,
                        'category_id' => $rule['category'],
                        'level' => $rule['level']
                    ];
                    $direction_rule = DirectionRule::where('id', $rule['id'])->update($data_rule);
                    $data_rules[] = $rule['id'];
                } else {
                    $data_rule = [
                        'direction_id' => $direction->id,
                        'category_id' => $rule['category'],
                        'level' => $rule['level']
                    ];
                    $direction_rule = DirectionRule::create($data_rule);
                    $data_rules[] = $direction_rule->id;
                }
            }
            DirectionRule::whereNotIn('id', $data_rules)->delete();
        } catch (Exception $e) {
            Log::error($e);
            return $this->sendError(null, __('admin.message.error'));
        }
        return $this->sendResponse(null, __('admin.message.success'));
    }

}
