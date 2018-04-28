<?php

namespace App\Jobs;

use App\Course;
use App\Faculty;
use App\Lector;
use App\Program;
use App\Semester;
use App\Student;
use App\Submission;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ImportSurveyData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Imports data from the file.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Attempting to import '.$this->path);

        if (!file_exists($this->path)) return false;

        $file = fopen($this->path, 'r');

        $recordCount = -1; // First line is a header line.
        while (fgets($file) !== false) $recordCount++;

        Log::info("File contains $recordCount records");

        fseek($file, 0);

        // "Npk", "ID", "Fakultāte", "Programma", "Finans.",
        // "Statuss", "Stud.forma", "Kārto", "Datums", "Ilgums(h-min-s)",
        // "Vid.vērt.", "Māc.gads", "Kurss", "Nosauk.", "KP",
        // "Pasniedz.", "Amats",

//         "Pasniedzējs vadīja kursa sekojošas daļas",
//         "Studiju kursa saturs atbilda kursa aprakstam",
//         "Studiju kursa saturs lieki nedublēja citu kursu",
//         "Mācībspēks kursa tēmas izklāstīja saprotami",
//         "Mācībspēka lietotās mācību metodes veicināja studiju kursa apguvi",
//         "Ieteiktā literatūra un materiāli bija viegli pieejami un lietderīgi",
//         "E-kursā pieejamie materiāli palīdzēja studiju kursa apguvē, ja kursam nebija e-kursa, jāatzīmē atbilžu variants „Nezinu, nevaru pateikt”",
//         "Pārbaudes darbi semestra laikā veicināja studiju kursa apguvi",
//         "Mācībspēks bija pieejams konsultācijām",
//         "Studiju kursa laikā sasniedzu studiju kursa aprakstā ierakstītos studiju rezultātus",
//         "Labprāt klausītos vēl kādu kursu pie šī mācībspēka",
//         "Mācībspēka skaidrojumi par pārbaudes darbu rezultātiem ir pietiekami",
//         "Komentāri un ieteikumi par šo kursu un pasniedzēju",
//         "Stundas, ko vidēji nedēļā veltīju šī kursa apguvei, tai skaitā darbs auditorijās, gatavošanās nodarbībām, veicot uzdotos praktiskos darbus:",

        // ID, programma, semestris

        $recordsImported = 0;
        $recordsOmited = 0;
        $recordsProcessed = 0;
        $headers = fgetcsv($file);

        $course = new Course;
        $faculty = new Faculty;
        $lector = new Lector;
        $program = new Program;
        $semester = new Semester;
        $student = new Student;

        while ($row = fgetcsv($file))
        {
            // Get faculty
            if ($faculty->abbreviation != $row[2])
            {
                $faculty = Faculty::abbreviation($row[2])->first();
            }

            // Get program
            if ($program->id != $row[3])
            {
                $program = Program::firstOrCreate([
                    'id' => $row[3],
                ]);
            }

            // Get semester
            if ($semester->code != $row[11])
            {
                $semester = Semester::firstOrCreate([
                    'code' => $row[11],
                ], [
                    'name' => str_replace('.', '. ', $row[11]),
                ]);
            }

            // Get student
            if ($student->id != $row[1])
            {
                $student = Student::firstOrCreate([
                    'id' => $row[1],
                ],
                    [
                        'faculty_id' => $faculty->id,
                        'program_id' => $program->id,
                        'funding' => $row[4],
                        'status' => $row[5],
                        'type' => $row[6],
                    ]);
            }

            // Get course
            if ($course->code != $row[12])
            {
                $course = Course::where('code', $row[12])->first();
                if ($course == null)
                {
                    $course = $program->courses()->create(
                        [
                            'code' => $row[12],
                            'name' => $row[13],
                            'credits' => $row[14],
                        ],
                        [
                            'semester_id' => $semester->id
                        ]
                    );
                }
            }

            // Get lector
            if ($lector->name != $row[15])
            {
                $lector = Lector::firstOrCreate([
                    'name' => $row[15],
                ]);
            }

            $row[9] = strlen($row[9]) ? $row[9] : '0-0-0';
            $timeParts = explode('-', $row[9]);
            $time = $timeParts[0]*3600 + $timeParts[1]*60 + $timeParts[2];

            $exists = Submission::where([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'lector_id' => $lector->id,
                'semester_id' => $semester->id,
            ])->first();

            if (!$exists)
            {
                Submission::create([
                    'student_id' => $student->id,
                    'faculty_id' => $faculty->id,
                    'program_id' => $program->id,
                    'times_taken' => $row[7],
                    'started_at' => Carbon::createFromFormat('d.m.Y H:i:s',$row[8]),
                    'duration' => $time,
                    'semester_id' => $semester->id,
                    'course_id' => $course->id,
                    'lector_id' => $lector->id,
                    'position' => $row[16],

                    'course_parts' => $row[17],
                    'course_description' => $row[18],
                    'course_duplication' => $row[19],
                    'lecturer_understandable' => $row[20],
                    'lecturer_methods' => $row[21],
                    'literature_usefullness' => $row[22],
                    'estudies_materials' => $row[23],
                    'course_tests' => $row[24],
                    'lecturer_consultations' => $row[25],
                    'course_results' => $row[26],
                    'lecturer_again' => $row[27],
                    'test_explanation' => $row[28],
                    'comments' => $row[29],
                    'course_time' => $row[30],
                ]);
                $recordsImported++;
            }
            else
            {
                $recordsOmited++;
            }

            if ($recordsProcessed % round($recordCount/20) === 0)
            {
                Log::info(sprintf('%d%% of records processed', $recordsProcessed/$recordCount*100));
            }
            $recordsProcessed++;
        }

        fclose($file);
        Log::info('100% of records processed');
        Log::info("Imported records: $recordsImported/$recordCount (".round($recordsImported/$recordCount*100, 2)."%), omited: $recordsOmited(".round($recordsOmited/$recordCount*100, 2)."%)");
    }
}
