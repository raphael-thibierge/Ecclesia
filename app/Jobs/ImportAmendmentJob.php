<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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

            echo '.';

        }
    }
}
