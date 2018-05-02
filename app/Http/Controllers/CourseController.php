<?php

namespace App\Http\Controllers;

use App\Course;
use App\Program;
use App\Semester;
use App\Submission;
use App\SubmissionFilters;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $res = Submission::select([
                'comments',
            ])
            ->addSelect(Submission::getQuestionAttributes())
            ->where(['course_id' => 50, 'semester' => '2017.rudens'])
            ->get();

        $data = [];

        foreach(Submission::$questions as $key => $question)
        {
            $data[$question] = $res->pluck($key);
        }

        $data = json_encode($data);
        $comments = $res->pluck('comments');

        return view('course.dashboard', compact('data', 'comments'));
    }

    public function show(Request $request, SubmissionFilters $filters, Program $program, Semester $semester, Course $course)
    {
        $coursemeta = [
            'semester' => $semester,
            'parts' => [
                'all' => 'Viss kurss',
                'lectures' => 'Lekcijas',
                'seminars' => 'Semināri',
                'practice' => 'Praktiskie darbi',
                'labs' => 'Laboratorijas darbi',
            ],
            'part' => $filters->has('part') ? $filters->get('part') : 'all',
        ];

        $submissions = Submission::select([
            'lector_id',
            'position',
            'comments',
        ])
            ->addSelect(Submission::getQuestionAttributes())
            ->where(['course_id' => $course->id, 'semester_id' => $semester->id])
            ->filter($filters)
            ->get();

        $data = [];

        // Get answers for all the questions
        foreach(Submission::$questions as $key => $question)
        {
            $data[$question] = $submissions->pluck($key);
        }

        $data = json_encode($data);
        return view('course.show', compact('program', 'semester', 'course', 'coursemeta', 'data', 'filters', 'submissions'));
    }
}
