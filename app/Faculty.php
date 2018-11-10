<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    protected $guarded = [];

    public function programs() : HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function scopeName(Builder $query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeAbbreviation(Builder $query, $abbr)
    {
        return $query->where('abbreviation', $abbr);
    }
}
