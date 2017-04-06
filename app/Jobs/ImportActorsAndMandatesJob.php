<?php

namespace App\Jobs;

use App\Actor;
use App\Mandate;
use App\OpenDataFile;
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

        $file = OpenDataFile::find($this->openDataFileId);

        $file->download();
        $file->unzip();

        // get xml file
        $xml = new SimpleXMLElement(storage_path($file->xmlPath()), null, true);

        // get actors
        $actors = $xml->acteurs;

        // foreach actors
        foreach ($actors->acteur as $acteurElement) {

            $actorXML = $acteurElement;

            $actorId = self::formatString($actorXML->uid);

            $etatCivil = $actorXML->etatCivil;
            $ident = $etatCivil->ident;
            $birthInfos = $etatCivil->infoNaissance;

            // define attributes array
            $attributes = [
                'uid'                => $actorId,
                'first_name'         => self::formatString($ident->prenom),
                'last_name'          => self::formatString($ident->nom),
                'gender'            => $ident->civ->__toString() == 'M.' ? 'male' : 'female',
                'birth_date'        => self::formatString($birthInfos->dateNais),
                'birth_city'        => self::formatString($birthInfos->villeNais), // can be null
                'birth_department'  => self::formatString($birthInfos->depNais), // can be null
                'birth_country'     => self::formatString($birthInfos->paysNais), // can be null
                'death_date'        => self::formatString($etatCivil->dateDeces), // can be null
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

                $mandateId = self::formatString($mandateXML->uid);


                // define attributes
                $attributes = [
                    'uid'                   => $mandateId,
                    'actor_uid'             => $actorId,
                    'organ_type'            => self::formatString($mandateXML->typeOrgane),
                    'start_date'            => self::formatString($mandateXML->dateDebut),
                    'end_date'              => self::formatString($mandateXML->dateFin),// can be null
                    'taking_office_date'    => self::formatString($mandateXML->mandature->datePriseFonction),// can be null
                    'quality'               => self::formatString($mandateXML->infosQualite->codeQualite), // can be null
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


    static private function formatString($element){

        if ($element == null){
            return null;
        }
        $string = $element->__toString();
        return $string != null ? $string : null;
    }
}
