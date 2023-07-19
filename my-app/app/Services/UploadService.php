<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class UploadService extends BaseService
{
    public function uploadPhotoCourse($request) {
        if($request->file('photo')){
            $file_name = time().'_'.$request->photo->getClientOriginalName();
            $file_path = $request->file('photo')->storeAs('uploads', $file_name, 'public');
            return $file_path;
        }
        return null;
    }
}