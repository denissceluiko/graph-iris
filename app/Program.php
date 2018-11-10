<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Program extends Model
{
    protected $guarded = [];

    public function courses(Semester $semester = null)
    {
        if (!$semester)
        {
            return $this->belongsToMany(Course::class);
        }

        return $this->belongsToMany(Course::class)->wherePivot('semester_id', $semester->id);
    }

    public function scopeLuis(Builder $query, $code)
    {
        return $query->where('luis', $code)->first();
    }
}
