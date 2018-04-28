<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use Filterable;

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'started_at'
    ];

    protected $gradeableAttributes = [
        'course_description',
        'course_duplication',
        'lecturer_understandable',
        'lecturer_methods',
        'literature_usefullness',
        'estudies_materials',
        'course_tests',
        'lecturer_consultations',
        'course_results',
        'lecturer_again',
        'test_explanation',
    ];

    static $questions = [
        'course_description' => "Studiju kursa saturs atbilda kursa aprakstam",
        'course_duplication' => "Studiju kursa saturs lieki nedublēja citu kursu",
        'lecturer_understandable' => "Mācībspēks kursa tēmas izklāstīja saprotami",
        'lecturer_methods' => "Mācībspēka lietotās mācību metodes veicināja studiju kursa apguvi",
        'literature_usefullness' => "Ieteiktā literatūra un materiāli bija viegli pieejami un lietderīgi",
        'estudies_materials' => "E-kursā pieejamie materiāli palīdzēja studiju kursa apguvē",
        'course_tests' => "Pārbaudes darbi semestra laikā veicināja studiju kursa apguvi",
        'lecturer_consultations' => "Mācībspēks bija pieejams konsultācijām",
        'course_results' => "Studiju kursa laikā sasniedzu studiju kursa aprakstā ierakstītos studiju rezultātus",
        'lecturer_again' => "Labprāt klausītos vēl kādu kursu pie šī mācībspēka",
        'test_explanation' => "Mācībspēka skaidrojumi par pārbaudes darbu rezultātiem ir pietiekami",
    ];

    protected $partsToInt = [
        'Visu kursu',
        'Lekcijas',
        'Seminārus',
        'Praktiskos darbus',
        'Laboratorijas darbus',
    ];

    protected $numbersToGrades = [
        'Nezinu, nevaru pateikt',
        'Pilnīgi nepiekrītu',
        'Pārsvarā nepiekrītu',
        'Drīzāk nepiekrītu',
        'Neitrāli',
        'Drīzāk piekrītu',
        'Pārsvarā piekrītu',
        'Pilnīgi piekrītu',
    ];

    protected $intToTime = [
        'Mazāk kā 3 stundas',
        '3-5 stundas',
        '6-9 stundas',
        '10-14 stundas',
        '15-20 stundas',
        '21-29 stundas',
        'Vairāk kā 30 stundas',
    ];

//    public function getAttribute($key)
//    {
//        if (in_array($key, $this->gradeableAttributes))
//        {
//            return $this->numbersToGrades[$this->getAttributeValue($key) ?? 0];
//        }
//        else
//        {
//            return parent::getAttribute($key);
//        }
//    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->gradeableAttributes))
        {
            $value = array_search($value, $this->numbersToGrades);
            $this->attributes[$key] = $value > 0 ? $value : null;
        }
        else
        {
            parent::setAttribute($key, $value);
        }
    }

    public function getCourseTimeAttribute()
    {
        return $this->intToTime[$this->course_time];
    }

    public function setCourseTimeAttribute($value)
    {
        $this->attributes['course_time'] = array_search($value, $this->intToTime);
    }

    public function getCoursePartsAttribute()
    {
        $results = [];

        for($i = 0; $i < 5; $i++)
        {
            if($this->attributes['course_parts'] & (1 << $i) == (1 << $i))
                $results[] = $this->partsToInt[$i];
        }
        return implode(', ', $results);

    }

    public function setCoursePartsAttribute($value)
    {
        $parts = explode(',', $value);

        if (!isset($this->attributes['course_parts']))
            $this->attributes['course_parts'] = 0;

        for($i = 0; $i < 5; $i++)
        {
            if(in_array($this->partsToInt[$i], $parts))
                $this->attributes['course_parts'] |= (1 << $i);
        }
    }

    static function getQuestionAttributes()
    {
        return array_keys(self::$questions);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lector()
    {
        return $this->belongsTo(Lector::class);
    }
}
