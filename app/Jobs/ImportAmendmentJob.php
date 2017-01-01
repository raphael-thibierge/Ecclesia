<?php

namespace App\Jobs;

use App\Amendment;
use App\OpenDataFile;
use App\Services\Utils;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleXMLElement;

class ImportAmendmentJob implements ShouldQueue
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

        echo PHP_EOL . 'ImportAmendmentJob' . PHP_EOL;

        $file = OpenDataFile::find($this->openDataFileId);

        $file->download();
        $file->unzip();

        $file->update();
        echo PHP_EOL . 'xml loaded' . PHP_EOL;

        // get xml file
        $xmlData = new SimpleXMLElement(storage_path($file->xmlPath()), null, true);
        var_dump($xmlData);
        echo PHP_EOL;

        // foreach vote
        foreach ($xmlData as $textXML) {


            $legislative_document_uid = Utils::formatString($textXML->refTexteLegislatif);

            foreach ($textXML->amendements->amendement as $amendementXML){
                $attributes = $this->getAmendmentAttribute($amendementXML, $legislative_document_uid);

                $this->findAmendmentOrCreate($attributes);

            }

            echo '.';

        }
        echo PHP_EOL . 'Finished' . PHP_EOL;
    }

    private function getAmendmentAttribute($xmlData, $legislative_document_uid)
    {
        //dd($xmlData);
        return [
            'uid'  => Utils::formatString($xmlData->uid),
            'legislative_document_uid'  => $legislative_document_uid,
            'text_step'  => Utils::formatString($xmlData->etapeTexte),
            'amendment_sorting'  => Utils::formatString($xmlData->triAmendement),
            'state'  => Utils::formatString($xmlData->etat),
            'author_uid'  => Utils::formatString($xmlData->signataires->auteur->acteurRef),
            'co_author_uid'  => Utils::formatString($xmlData->signataires->cosignataires->acteurRef),
            'text_fragment_pointer_title'  => Utils::formatString($xmlData->pointeurFragmentTexte->division->titre),
            'text_fragment_pointer_short_title'  => Utils::formatString($xmlData->pointeurFragmentTexte->division->articleDesignationCourte),
            'content'  => Utils::formatString($xmlData->corps->dispositif),
            'content_summary'  => Utils::formatString($xmlData->corps->exposeSommaire),
            'decision'  => Utils::formatString($xmlData->sort->sortEnSeance),
            'decision_date'  => Utils::formatDate($xmlData->sort->dateSaisie),
            'deposit_date'  => Utils::formatDate($xmlData->dateDepot),
            'distribution_date'  => Utils::formatDate($xmlData->dateDistribution),
        ];
    }

    private function findAmendmentOrCreate($attributes)
    {
        $amendment = Amendment::find($attributes['uid']);
        if ($amendment != null){
            $amendment->update($attributes);
        } else {
            Amendment::create($attributes);
        }
    }
}
