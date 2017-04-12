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
            'name'          => 'Acteurs',
            'description'   => 'Députés / Nominations / Organes',
            'url'           => 'http://data.assemblee-nationale.fr/static/openData/repository/AMO/deputes_senateurs_ministres_legislature/AMO20_dep_sen_min_tous_mandats_et_organes_XIV.xml.zip',
            'import_script' => 'ImportActorsAndMandatesJob',
        ]);

        OpenDataFile::create([
            'name'          => 'Votes',
            'description'   => 'Les scrutins AN (réalisés sur la machine de vote)',
            'url'           => 'http://data.assemblee-nationale.fr/static/openData/repository/LOI/scrutins/Scrutins_XIV.xml.zip',
            'import_script' => 'ImportVotesJob',
        ]);

        OpenDataFile::create([
            'name'          => 'Amendements',
            'description'   => 'Tous les amendements publiés durant la législature groupés par texte de loi',
            'url'           => 'http://data.assemblee-nationale.fr/static/openData/repository/LOI/amendements_legis/Amendements_XIV.xml.zip',
            'import_script' => 'ImportAmendmentJob',
        ]);

        OpenDataFile::create([
            'name'          => 'Travaux parlementaires',
            'description'   => 'Dossiers législatifs de la 14ème législature et notices des textes associés',
            'url'           => 'http://data.assemblee-nationale.fr/static/openData/repository/LOI/dossiers_legislatifs/Dossiers_Legislatifs_XIV.xml.zip',
            'import_script' => 'ImportLegislativeFoldersJob',
        ]);

    }
}
