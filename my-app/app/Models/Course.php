<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    const EASY = 1;
    const MEDIUM = 2;
    const HARD = 3;

    const THUMBNAIL_WIDTH = 360;
    const THUMBNAIL_HEIGHT = 180;

    protected $fillable = [
        'name', 'description', 'price', 'level', 'photo', 'category_id', 'teacher_id',
    ];

    public static function getLevel($level_id)
    {
        $level_str = ['', 'Easy', 'Medium', 'Hard'];
        return $level_str[$level_id];
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

     public function num_enrolls()
     {
         return $this->hasMany('App\Models\Enroll', 'course_id', 'id');
     }

     public function parts()
     {
        return $this->hasMany(CoursePart::class, 'course_id');
     }
}
