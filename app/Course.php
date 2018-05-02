<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    public function semesters()
    {
        return $this->belongsToMany(Semester::class);
    }

    public function scopeCode(Builder $query, $code)
    {
        return $query->where('code', $code);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
