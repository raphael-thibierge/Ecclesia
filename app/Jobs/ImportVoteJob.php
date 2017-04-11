<?php

    namespace App\Jobs;

use App\OpenDataFile;
use App\Services\Utils;
use App\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleXMLElement;

class ImportVoteJob implements ShouldQueue
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

        $file->download();
        $file->unzip();

        // get xml file
        $xml = new SimpleXMLElement(storage_path($file->xmlPath()), null, true);

        // foreach vote
        foreach ($xml->scrutin as $scrutinElement) {


            $voteXML = $scrutinElement;

            $attributes = $this->getVoteAttribute($voteXML);

            $this->findVoteOrCreate($attributes);
            
            // get ballots
            //$ballots = $voteXML->miseAuPoint;


            echo '.';

        }


    }


    private function getVoteAttribute($voteXML){

        $description =
            Utils::formatString($voteXML->sort->libelle) . ' ' .
            Utils::formatString($voteXML->objet->libelle);

        // define attributes array
        $attributes = [
            'uid'               => Utils::formatString($voteXML->uid),
            'number'            => Utils::formatString($voteXML->numero),
            'date'              => Utils::formatString($voteXML->dateScrutin),
            'decision'          => Utils::formatString($voteXML->sort->code),
            'applicant'         => Utils::formatString($voteXML->demandeur->texte),
            'title'             => Utils::formatString($voteXML->titre),
            'description'       => $description,
            'object'             => Utils::formatString($voteXML->objet->libelle),
        ];

        return $attributes;
    }


    private function findVoteOrCreate($attributes){
        // if vote exist in database
        if (($vote = Vote::find($attributes['uid'])) != null){
            // update attributes
            $vote->update($attributes);
        }
        // else
        else {
            // create vote
            Vote::create($attributes);
        }
    }


    public function getBallotAttributes($voteId, $ballotDecision, $voter){
        $attributes = [
            'vote_uid'      => $voteId,
            'actor_uid'     => Utils::formatString($voter->acteurRef),
            'mandate_uid'   => Utils::formatString($voter->mandatRef),
            'decision'      => $ballotDecision,
        ];
    }


}
