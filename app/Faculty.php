<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $guarded = [];

    public function scopeAbbreviation(Builder $query, $abbr)
    {
        return $query->where('abbreviation', $abbr);
    }
}
