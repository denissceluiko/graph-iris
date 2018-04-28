<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $guarded = [];
    public $incrementing = false;

    public function courses(Semester $semester = null)
    {
        if (!$semester)
        {
            $semester = Semester::latest()->first();
        }

        return $this->belongsToMany(Course::class)->wherePivot('semester_id', $semester->id);
    }
}
