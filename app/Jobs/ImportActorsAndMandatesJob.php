<?php

namespace App\Jobs;

use App\Actor;
use App\Mandate;
use App\OpenDataFile;
use App\Organ;
use App\Services\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleXMLElement;

class ImportActorsAndMandatesJob implements ShouldQueue
{

    /**
     * @var string
     */
    private $openDataFileId;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OpenDataFile $file)
    {
        $this->openDataFileId = $file->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        echo PHP_EOL . 'ImportActorsAndMandatesJob' . PHP_EOL;

        $file = OpenDataFile::find($this->openDataFileId);

        $file->download();
        $file->unzip();

        // get xml file
        $xml = new SimpleXMLElement(storage_path($file->xmlPath()), null, true);



        $organs = $xml->organes;

        foreach ($organs->organe as $organ){

            $organAttributes = $this->getOrganAttributes($organ);

            $this->updateOrCreateOrgan($organAttributes);

            echo '.';
        }

        echo PHP_EOL . 'actors' . PHP_EOL;


        // get actors
        $actors = $xml->acteurs;

        // foreach actors
        foreach ($actors->acteur as $acteurElement) {

            $actorXML = $acteurElement;

            $actorId = Utils::formatString($actorXML->uid);

            $etatCivil = $actorXML->etatCivil;
            $ident = $etatCivil->ident;
            $birthInfos = $etatCivil->infoNaissance;

            // define attributes array
            $attributes = [
                'uid'                => $actorId,
                'first_name'         => Utils::formatString($ident->prenom),
                'last_name'          => Utils::formatString($ident->nom),
                'gender'            => $ident->civ->__toString() == 'M.' ? 'male' : 'female',
                'birth_date'        => Utils::formatString($birthInfos->dateNais),
                'birth_city'        => Utils::formatString($birthInfos->villeNais), // can be null
                'birth_department'  => Utils::formatString($birthInfos->depNais), // can be null
                'birth_country'     => Utils::formatString($birthInfos->paysNais), // can be null
                'death_date'        => Utils::formatString($etatCivil->dateDeces), // can be null
            ];


            // if actor exist in database
            if (($actor = Actor::find($actorId)) != null){
                // update attributes
                $actor->update($attributes);
            }
            // else
            else {
                // create actor
                Actor::create($attributes);
            }

            // get mandates
            $mandates = $actorXML->mandats;
            // foreach mandates
            foreach ($mandates->mandat as $mandateElement) {


                $mandateXML = $mandateElement;

                $mandateId = Utils::formatString($mandateXML->uid);


                // define attributes
                $attributes = [
                    'uid'                   => $mandateId,
                    'actor_uid'             => $actorId,
                    'organ_type'            => Utils::formatString($mandateXML->typeOrgane),
                    'organ_uid'            => Utils::formatString($mandateXML->organes->organeRef),
                    'start_date'            => Utils::formatString($mandateXML->dateDebut),
                    'end_date'              => Utils::formatString($mandateXML->dateFin),// can be null
                    'taking_office_date'    => Utils::formatString($mandateXML->mandature->datePriseFonction),// can be null
                    'quality'               => Utils::formatString($mandateXML->infosQualite->codeQualite), // can be null
                ];

                // if mandate exist in database
                if (($mandate = Mandate::find($mandateId)) != null){
                    // update attributes
                    $mandate->update($attributes);
                }
                // else
                else {
                    // create mandate
                    Mandate::create($attributes);
                }
            }

            echo '.';

        }


    }

    private function getOrganAttributes($organ) : array
    {
        return [
            'uid'       => Utils::formatString($organ->uid),
            'type'       => Utils::formatString($organ->codeType),
            'title'       => Utils::formatString($organ->libelle),
            'short_title'       => Utils::formatString($organ->libelleAbrege),
            'edition_title'       => Utils::formatString($organ->libelleEdition),
        ];
    }

    private function updateOrCreateOrgan(array $organAttributes)
    {
        // if organ exist in database
        if (($organ = Organ::find($organAttributes['uid'])) != null){
            // update attributes
            $organ->update($organAttributes);
        }
        // else
        else {
            // create actor
            Organ::create($organAttributes);
        }
    }


}
