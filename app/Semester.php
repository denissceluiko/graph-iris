<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $guarded = [];

    public function scopeLatest(Builder $query)
    {
        return $query->orderByDesc('code')->take(1);
    }

    public function getRouteKeyName()
    {
        return 'code';
    }
}
