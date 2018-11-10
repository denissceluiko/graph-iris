<?php

namespace App\Jobs;

use App\Faculty;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ImportProgramData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $path;
    private $jobname = '[JOB] Import program and faculty data';

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info($this->jobname.' started.');

        if (!file_exists($this->path))
        {
            Log::info($this->jobname.' failed. File does not exist: '.$this->path);
            return;
        }

        $file = fopen($this->path, 'r');

        // Get headers
        // "LRI kods", "LUIS kods", "Programma", "Strukt."
        $row = fgets($file);
        $processed = 0;

        while ($row = fgetcsv($file))
        {
            $this->processRow($row);
            $processed++;
        }

        fclose($file);
        Log::info($this->jobname." successful. $processed records processed.");
    }

    private function processRow($row)
    {
        $faculty = $this->getFaculty($row[3]);

        $faculty->programs()->updateOrCreate([
            'luis' => $row[1],
        ], [
            'name' => $row[2],
            'lri' => $row[0],
        ]);
    }

    private function getFaculty($name)
    {
        if(preg_match_all('/\b(\w)/',strtoupper($name),$m)) {
            $abbr = implode('',$m[1]);
        }

        return Faculty::firstOrCreate([
            'name' => $name,
        ], [
            'abbreviation' => $abbr.'_PRO',
        ]);
    }
}
