<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    public function Rule() {
        return $this->hasMany(DirectionRule::class, 'direction_id');
    }
}