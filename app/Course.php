<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
}
