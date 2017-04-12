<?php

    namespace App\Jobs;

use App\Ballot;
use App\OpenDataFile;
use App\Services\Utils;
use App\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SimpleXMLElement;

class ImportVotesJob implements ShouldQueue
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

        $cpt = 0;
        // foreach vote
        foreach ($xml->scrutin as $scrutinElement) {

            $voteXML = $scrutinElement;

            $attributes = $this->getVoteAttribute($voteXML);

            $this->findVoteOrCreate($attributes);


            // get ballots
            $ballots = $voteXML->miseAuPoint;

            if (!empty($ballots->nonVotants)){
                foreach ($ballots->nonVotants->votant as $voter){
                    $ballotAttributes = $this->getBallotAttributes($attributes['uid'], 'nonVotant', $voter );
                    $this->updateBallotOrCreate($ballotAttributes);
                }
            }

            if (!empty($ballots->pours)) {
                foreach ($ballots->pours->votant as $voter) {
                    $ballotAttributes = $this->getBallotAttributes($attributes['uid'], 'pour', $voter);
                    $this->updateBallotOrCreate($ballotAttributes);
                }
            }

            if (!empty($ballots->contres)) {
                foreach ($ballots->contres->votant as $voter) {
                    $ballotAttributes = $this->getBallotAttributes($attributes['uid'], 'contre', $voter);
                    $this->updateBallotOrCreate($ballotAttributes);
                }
            }

            if (!empty($ballots->abstentions)) {
                foreach ($ballots->abstentions->votant as $voter) {
                    $ballotAttributes = $this->getBallotAttributes($attributes['uid'], 'abstention', $voter);
                    $this->updateBallotOrCreate($ballotAttributes);
                }
            }

            if (!empty($ballots->nonVotantsVolontaires)) {
                foreach ($ballots->nonVotantsVolontaires->votant as $voter) {
                    $ballotAttributes = $this->getBallotAttributes($attributes['uid'], 'nonVotantVolontaire', $voter);
                    $this->updateBallotOrCreate($ballotAttributes);
                }
            }

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
        return [
            'vote_uid'      => $voteId,
            'actor_uid'     => Utils::formatString($voter->acteurRef),
            'mandate_uid'   => Utils::formatString($voter->mandatRef),
            'decision'      => $ballotDecision,
        ];
    }

    public function updateBallotOrCreate($attributes){
        $ballot = Ballot::where('vote_uid', $attributes['vote_uid'])
                        ->where('actor_uid', $attributes['actor_uid'])
                        ->first();
        if ($ballot != null){
            $ballot->update($attributes);
        } else {
            Ballot::create($attributes);
        }
    }


}
