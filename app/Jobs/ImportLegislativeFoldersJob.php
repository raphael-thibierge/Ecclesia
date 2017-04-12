<?php

namespace App\Jobs;

use App\Actor;
use App\LegislativeAct;
use App\LegislativeDocument;
use App\LegislativeFolder;
use App\OpenDataFile;
use App\Organ;
use App\Services\Utils;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleXMLElement;

class ImportLegislativeFoldersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $openDataFileId;

    /**
     * Create a new job instance.
     *
     * @param OpenDataFile $file
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

//        $file->download();
//        $file->unzip();

        // get xml file
        $xml = new SimpleXMLElement(storage_path($file->xmlPath()), null, true);


        $legislativeDocuments = $xml->textesLegislatifs->document;

        foreach ($legislativeDocuments as $documentXML){

            $attributes = $this->getLegislativeDocumentAttributes($documentXML);

            $document = $this->updateOrCreateLegislativeDocument($attributes);

            $this->associateAuthors($document, $documentXML);


            echo '.';
        }

        echo PHP_EOL . '$legislativeFolder' . PHP_EOL;


        $legislativeFolder = $xml->dossiersLegislatifs;

        // foreach vote
        foreach ($legislativeFolder->dossier as $folder) {

            $attributes = $this->getLegislativeFolderAttribute($folder->dossierParlementaire);

            $this->updateOrCreateLegislativeFolder($attributes);

            $legislativeActs = $folder->dossierParlementaire->actesLegislatifs;

            $this->legislativesActsRecursive($legislativeActs, $attributes['uid']);

            echo '.';

        }
    }

    private function getLegislativeFolderAttribute($folder)
    {
        return [
            'uid'       => Utils::formatString($folder->uid),
            'title'       => Utils::formatString($folder->titreDossier->titre),
            'url'       => Utils::formatString($folder->titreDossier->senatChemin),
            'parliamentaryProcedureCode'       => Utils::formatString($folder->procedureParlementaire->code),
            'parliamentaryProcedureTitle'       => Utils::formatString($folder->procedureParlementaire->libelle),
        ];
    }


    private $test = [];

    private function legislativesActsRecursive($legislativesActs, $legislativeFolderId){
        if (!empty($legislativesActs->acteLegislatif)) {
            foreach ($legislativesActs->acteLegislatif as $legislativesAct) {

                $attributes = [
                    'uid' => Utils::formatString($legislativesAct->uid),
                    'legislative_folder_uid' => $legislativeFolderId,
                    'actCode' => Utils::formatString($legislativesAct->codeActe),
                    'title' => Utils::formatString($legislativesAct->libelleActe->libelleCourt),
                    'organ_uid' => Utils::formatString($legislativesAct->organeRef),
                    'date' => self::formatDate($legislativesAct->date),
                ];

                $this->updateOrCreateLegislativeAct($attributes);

                $this->legislativesActsRecursive($legislativesAct->actesLegislatifs, $legislativeFolderId);
            }
        }
    }


    public function updateOrCreateLegislativeAct(array $attributes){

        $act = LegislativeAct::find($attributes['uid']);
        if ($act != null){
            $act->update($attributes);
        } else {
            LegislativeAct::create($attributes);
        }
    }

    public function updateOrCreateLegislativeFolder(array $attributes){

        $folder = LegislativeFolder::find($attributes['uid']);
        if ($folder != null){
            $folder->update($attributes);
        } else {
            LegislativeFolder::create($attributes);
        }
    }

    private function getLegislativeDocumentAttributes($document)
    {

        return [
            'uid'   => Utils::formatString($document->uid),
            'title'   => Utils::formatString($document->titres->titrePrincipal),
            'classificationTypeCode'   => Utils::formatString($document->classification->type->code),
            'classificationTypeTitle'   => Utils::formatString($document->classification->type->libelle),
            'classificationUnderTypeCode'   => Utils::formatString($document->classification->sousType->code),
            'classificationUnderTypeTitle'   => Utils::formatString($document->classification->sousType->libelle),
            'adoptionStatus'   => Utils::formatString($document->classification->statutAdoption),
            'creation_date'   => self::formatDate($document->cycleDeVie->chrono->dateCreation),
            'deposit_date'   => self::formatDate($document->cycleDeVie->chrono->dateDepot),
            'publish_date'   => self::formatDate($document->cycleDeVie->chrono->datePublication),
        ];
    }


    private function associateAuthors(LegislativeDocument $document, $documentXML ){
        foreach ($documentXML->auteurs->auteur as $author){
            if (!empty($author->acteur)){
                $actorId = Utils::formatString($author->acteur->acteurRef);
                $actor = Actor::find($actorId);
                $document->author_actors()->attach($actor);
            }

            if (!empty($author->organe)){
                $organId = Utils::formatString($author->organe->organeRef);
                $organ = Organ::find($organId);
                $document->author_organs()->attach($organ);
            }
        }

        $document->save();


    }

    static function formatDate($element){
        $date = Utils::formatString($element);
        if ($date != null){
            $date = new Carbon($date);
        }
        return $date;
    }

    private function updateOrCreateLegislativeDocument(array $attributes) : LegislativeDocument
    {
        $document = LegislativeDocument::find($attributes['uid']);
        if ($document != null){
            $document->update($attributes);
        } else {
            $document = LegislativeDocument::create($attributes);
        }
        return $document;
    }

}

