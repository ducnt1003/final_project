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
}
