<?php

namespace App\Services;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function register($request) {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $rePassword = $request->re_password;
        if ($password != $rePassword) {
            return $this->sendError('Register fail',  __('admin.message.error'), 403);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role_id' => '0'
            ]);
            DB::table('students')->insert([
                'user_id' => $user->id,
                'school' => 'Đại học Bách Khoa Hà Nội',
                'major' => 'CNTT'
            ]);
            $token = Auth::login($user);
            DB::commit();
            return $this->respondWithToken($token);
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $this->sendError('Register fail',  __('admin.message.error'), 403);
        }


    }
    public function login($request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (! $token = Auth::attempt($credentials)) {
            return $this->sendError('Login fail',  __('admin.message.error'),JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        $user = Auth::user();
        return $this->sendResponse( [
            'user' => $user,
        ], __('admin.message.success'));
    }

    public function logout()
    {
        Auth::logout();
        return $this->sendResponse( 'Successfully logged out', __('admin.message.success'));
    }

    protected function respondWithToken($token)
    {
        $user = Auth::user();
        return $this->sendResponse( [
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => 60*60,
            'student' => $user->student ? $user->student : null
        ], __('admin.message.success'));
    }
}
