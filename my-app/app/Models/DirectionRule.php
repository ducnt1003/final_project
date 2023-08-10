<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectionRule extends Model
{
    use HasFactory;
    protected $table = 'direction_rule';

    protected $fillable = [
        'id',
        'direction_id',
        'category_id',
        'level',
    ];

    public $timestamps = true;
}
