<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePart extends Model
{
    use HasFactory;
    protected $table = 'course_parts';

    protected $fillable = [
        'id',
        'course_id',
        'part',
        'description',
    ];

    public $timestamps = true;
}
