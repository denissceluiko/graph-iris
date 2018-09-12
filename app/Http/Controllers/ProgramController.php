<?php

namespace App\Http\Controllers;

use App\Program;
use App\Semester;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $programs = Program::all();

        return view('program.index', compact('programs'));
    }

    public function dashboard(Request $request)
    {
        $res = DB::table('submissions')
            ->select(['name', DB::raw('count(*) as students, avg(course_description + course_duplication + lecturer_understandable + lecturer_methods + literature_usefullness + estudies_materials + course_tests + lecturer_consultations + course_results + lecturer_again + test_explanation)/11 as rating'), ])
            ->where(['semester' => '2016.pavasara'])
            ->groupBy('course_id')
            ->orderBy('name')
            ->join('courses', 'courses.id', '=','submissions.course_id')
            ->get();

        $res2 = DB::table('submissions')
            ->select(['name', DB::raw('count(*) as students, avg(course_description + course_duplication + lecturer_understandable + lecturer_methods + literature_usefullness + estudies_materials + course_tests + lecturer_consultations + course_results + lecturer_again + test_explanation)/11 as rating'), ])
            ->where(['semester' => '2017.pavasara'])
            ->groupBy('course_id')
            ->orderBy('name')
            ->join('courses', 'courses.id', '=','submissions.course_id')
            ->get();

        $trace = json_encode([
            [
                'x' => $res->pluck('name'),
                'y' => $res->pluck('rating'),
                'type' => 'scatter',
                'mode' => 'markers',
                'text' => $res->pluck('students'),
                'name' => '2016. pavasaris',
            ],
            [
                'x' => $res2->pluck('name'),
                'y' => $res2->pluck('rating'),
                'type' => 'scatter',
                'mode' => 'markers',
                'text' => $res2->pluck('students'),
                'name' => '2017. pavasaris',
            ],
        ]);

        return view('program.dashboard', compact('trace'));
    }

    public function edit(Program $program)
    {
        return view('program.edit', compact('program'));
    }

    public function show(Program $program, Semester $semester = null)
    {
        if (!$semester)
        {
            $semester = Semester::latest()->first();
        }

        $semesters = Semester::orderByDesc('code')->get();

        $courses = $program->courses($semester)->with(['submissions' => function($query) use ($semester) {
            return $query->where('semester_id', $semester->id);
        }])->orderBy('name')->get();

        $questions = Submission::$questions;

        return view('program.show', compact('program', 'semester', 'semesters', 'courses', 'questions'));
    }

    public function update(Request $request, Program $program)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $program->update($request->only('name'));

        return redirect()->route('program.show', $program);
    }
}
