<?php

namespace App;


class SubmissionFilters extends QueryFilters
{
    public function part($part = 'all')
    {
        $partsToInt = [
            'all' => 31,
            'lectures' => 2,
            'seminars' => 4,
            'practice' => 8,
            'labs' => 16,
        ];

        $part = !array_key_exists($part, $partsToInt) ? $partsToInt['all'] : $partsToInt[$part];

        $this->builder->whereRaw("(course_parts & $part) != 0");
    }

    public function lector($lector)
    {
        $this->builder->where('lector_id', $lector);
    }
}