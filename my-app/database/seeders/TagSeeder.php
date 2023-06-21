<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseTag;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->truncate();
        Tag::factory()->count(20)->create();
        $tags = Tag::all();
        $course_ids = Course::all()->pluck('id')->toArray();
        foreach ($tags as $tag) {
            $rand = rand(5, 15);
            $course_tag_ids = array_rand($course_ids, $rand);
            $data = [];
            foreach ($course_tag_ids as $course_tag_id) {
                $data[] = [
                   'course_id' =>  $course_tag_id,
                   'tag_id' => $tag->id,
                ];
            }
            CourseTag::insert($data);
        }
    }
}
