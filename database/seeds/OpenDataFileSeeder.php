<?php

use App\OpenDataFile;
use Illuminate\Database\Seeder;

class OpenDataFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        OpenDataFile::create([
            'name'          => 'Votes',
            'description'   => 'Députés / Nominations / Organes',
            'url'           => 'http://data.assemblee-nationale.fr/static/openData/repository/AMO/deputes_senateurs_ministres_legislature/AMO20_dep_sen_min_tous_mandats_et_organes_XIV.xml.zip',
            'import_script' => 'ImportActorsAndMandatesJob',
        ]);

    }
}
