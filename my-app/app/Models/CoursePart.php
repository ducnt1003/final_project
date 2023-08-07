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
        'name',
        'part',
        'description',
    ];

    public $timestamps = true;
    public function documents()
     {
        return $this->hasMany(Document::class, 'course_part_id');
     }
}
