<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTag extends Model
{
    use HasFactory;
    protected $table = 'course_tag';

    protected $fillable = [
        'id',
        'course_id',
        'tag_id',
    ];

    public $timestamps = true;
}