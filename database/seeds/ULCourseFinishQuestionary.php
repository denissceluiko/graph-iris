<?php

use Illuminate\Database\Seeder;

class ULCourseFinishQuestionary extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            'Pasniedzējs vadīja kursa sekojošas daļas' => ['multipleOptions'],
            'Studiju kursa saturs atbilda kursa aprakstam' => ['singleOption'],
            'Studiju kursa saturs nedublēja citu kursu' => ['singleOption'],
            'Mācībspēks kursa tēmas izklāstīja saprotami' => ['singleOption'],
            'Mācībspēka lietotās mācību metodes veicināja studiju kursa apguvi' => ['singleOption'],
            'Ieteiktā literatūra un materiāli bija viegli pieejami un lietderīgi' => ['singleOption'],
            'E-kursā pieejamie materiāli palīdzēja studiju kursa apguvē, ja kursam nebija e-kursa, jāatzīmē atbilžu variants „Nezinu, nevaru pateikt”' => ['singleOption'],
            'Pārbaudes darbi semestra laikā veicināja studiju kursa apguvi' => ['singleOption'],
            'Mācībspēks bija pieejams konsultācijām' => ['singleOption'],
            'Studiju kursa laikā sasniedzu studiju kursa aprakstā ierakstītos studiju rezultātus' => ['singleOption'],
            'Labprāt klausītos vēl kādu kursu pie šī mācībspēka' => ['singleOption'],
            'Mācībspēka skaidrojumi par pārbaudes darbu rezultātiem ir pietiekami' => ['singleOption'],
            'Komentāri un ieteikumi par šo kursu un pasniedzēju' => ['text'],
            'Stundas, ko vidēji nedēļā veltīju šī kursa apguvei, tai skaitā darbs auditorijās, gatavošanās nodarbībām, veicot uzdotos praktiskos darbus:' => ['singleOption'],
        ];


        foreach ($questions as $question => $options) {
            App\Question::create(['text' => $question, 'type' => $options[0]]);
        }

        $answers = [
            'Pilnīgi piekrītu' => 7,
            'Pārsvarā piekrītu' => 6,
            'Drīzāk piekrītu' => 5,
            'Neitrāli' => 4,
            'Drīzāk nepiekrītu' => 3,
            'Pārsvarā nepiekrītu' => 2,
            'Pilnīgi nepiekrītu' => 1,
            'Nezinu, nevaru pateikt' => null
        ];

        foreach ($answers as $answer => $numerical) {
            App\AnswerOption::create(['text' => $answer, 'numeric' => $numerical]);
        }
    }
}
