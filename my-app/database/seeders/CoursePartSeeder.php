<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CoursePart;
use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_parts')->truncate();
        DB::table('documents')->truncate();
        $courses = Course::all();
        foreach($courses as $course) {
            $CoursePart1 = CoursePart::create([
                'course_id' => $course->id,
                'part' => 1,
                'name' => 'Tổng quan'
            ]);
            Document::create([
                'course_part_id' => $CoursePart1->id,
                'name' => 'Mở đầu',
                'type' => 'mp4',
                'path' => '/intro.mp4'
            ]);
            Document::create([
                'course_part_id' => $CoursePart1->id,
                'name' => 'Giới thiệu',
                'type' => 'pdf',
                'path' => "/ui-ux1.pdf"
            ]);

            $CoursePart2 = CoursePart::create([
                'course_id' => $course->id,
                'part' => 2,
                'name' => 'Bài học đầu'
            ]);
            Document::create([
                'course_part_id' => $CoursePart2->id,
                'name' => 'Lý thuyết',
                'type' => 'pdf',
                'path' => "/ui-ux1.pdf"
            ]);
            Document::create([
                'course_part_id' => $CoursePart2->id,
                'name' => 'Thực hành',
                'type' => 'mp4',
                'path' => '/intro.mp4'
            ]);
        }
    }
}
