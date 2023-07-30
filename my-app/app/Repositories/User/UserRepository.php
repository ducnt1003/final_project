<?php

namespace App\Repositories\User;

use App\Models\Student;
use App\Models\User;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends AbstractRepository
{
    /**
     * @return string
     */
    protected function model()
    {
        return User::class;
    }

    public function searchStudent($key) {
        $results = DB::table('users')->select('students.id as value', DB::raw("CONCAT(users.name, '-', users.email) as label"))
        ->join('students', 'students.user_id', '=','users.id')
        ->where('users.name', 'like', "%$key%")
        ->orWhere('users.email', 'like', "%$key%")
        ->take(10)
        // return $results->toSql();
        ->get();

        return $results;
    }

}
