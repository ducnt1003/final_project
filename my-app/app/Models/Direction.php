<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'expert_id',
        'name',
        'description',
    ];

    public $timestamps = true;

    public function Rule() {
        return $this->hasMany(DirectionRule::class, 'direction_id');
    }

    public function Expert() {
        return $this->belongsTo(Expert::class, 'expert_id');
    }

    public function student_directions() {
        return $this->hasMany(StudentDirection::class, 'direction_id');
    }
}
