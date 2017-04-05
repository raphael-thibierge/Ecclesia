<?php

namespace App\Jobs;

use App\Actor;
use App\Mandate;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportActorsAndMandatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get xml file

        // get actors
        $actors = [];

        // foreach actors
        foreach ($actors as $actorXML) {

            $id = null;

            // define attributes array
            $attributes = [
                'uid'               => $id,
                'firstname',
                'lastname',
                'gender',
                'birth_date',
                'birth_department', // can be null
                'birth_country', // can be null
                'death_date', // can be null
            ];

            // if actor exist in database
            if (($actor = Actor::find($id)) != null){
                // update attributes
                $actor->update($attributes);
            }
            // else
            else {
                // create actor
                Actor::create($attributes);
            }
        }

        // get mandates
        $mandates = [];
        // foreach mandates
        foreach ($mandates as $mandateXML) {

            $id = null;


            // define attributes
            $attributes = [
                'uid'                   => $id,
                'actor_uid',
                'organ_type',
                'start_date',
                'end_date', // can be null
                'taking_office_date', // can be null
                'quality', // can be null
            ];

            // if mandate exist in database
            if (($mandate = Mandate::find($id)) != null){
                // update attributes
                $mandate->update($attributes);
            }
            // else
            else {
                // create mandate
                Mandate::create($attributes);
            }
        }
    }
}
