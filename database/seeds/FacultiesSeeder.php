<?php

use Illuminate\Database\Seeder;

class FacultiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = [
            ['BF', 'Bioloģijas fakultāte'],
            ['BVEF', 'Biznesa, vadības un ekonomikas fakultāte'],
            ['DF', 'Datorikas fakultāte'],
            ['FMF', 'Fizikas, matemātikas un optometrijas fakultāte'],
            ['ĢZZF', 'Ģeogrāfijas un zemes zinātņu fakultāte'],
            ['HZF', 'Humanitāro zinātņu fakultāte'],
            ['JF', 'Juridiskā fakultāte'],
            ['ĶF', 'Ķīmijas fakultāte'],
            ['MF', 'Medicīnas fakultāte'],
            ['PPMF', 'Pedagoģijas, psiholoģijas un mākslas fakultāte'],
            ['SZF', 'Sociālo zinātņu fakultāte'],
            ['TF', 'Teoloģijas fakultāte'],
            ['VFF', 'Vēstures un filozofijas fakultāte'],
        ];

        foreach ($faculties as $faculty)
        {
            \App\Faculty::create(['abbreviation' => $faculty[0], 'name' => $faculty[1]]);
        }
    }
}
