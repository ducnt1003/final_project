<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'course_part_id',
        'name',
        'description',
        'path',
        'type'
    ];

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => env('APP_URL').$value,
        );
    }

}
