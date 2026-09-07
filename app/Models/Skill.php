<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'mentor_id',
        'skill_name',
    ];

    public function mentor() {
        return $this->belongsTo(Mentor::class);
    }
}
