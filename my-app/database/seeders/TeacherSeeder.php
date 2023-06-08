<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 2
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 3
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Tiến sỹ',
            'user_id' => 4
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 5
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 6
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Tiến sỹ',
            'user_id' => 7
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 8
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Tiến sỹ',
            'user_id' => 9
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 10
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 11
        ]);

        DB::table('teachers')->insert([
            'work_place' => 'Đại học Bách Khoa Hà Nội',
            'level' => 'Giảng viên',
            'user_id' => 12
        ]);
    }
}
