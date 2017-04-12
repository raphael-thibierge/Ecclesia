<?php

namespace App;


use App\Jobs\ImportActorsAndMandatesJob;
use App\Jobs\ImportAmendmentJob;
use App\Jobs\ImportLegislativeFoldersJob;
use App\Jobs\ImportVotesJob;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use SimpleXMLElement;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;


/**
 * @property string url
 * @property string local_path
 * @property mixed file_name
 * @property mixed import_script
 * @property mixed id
 */
class OpenDataFile extends MongoModel
{

    protected $connection = 'mongodb';

    const ZIP_PATH = 'OpenData/zip/';
    const XML_PATH = 'OpenData/xml/';


    protected $collection = 'open_data_files';

    protected $primaryKey = '_id';



    protected $fillable = [
        'name',
        'url',
        'description',
        'file_name',
        'import_script',
    ];




    public function download(){

        $fileContent = file_get_contents($this->url);

        $fileParts = explode('/', $this->url);
        $this->file_name = $fileParts[count($fileParts)-1];

        $this->local_path = storage_path(self::ZIP_PATH . $this->file_name);

        file_put_contents($this->local_path, $fileContent);

        // stop here

    }

    public function unzip(){

        Zipper::make($this->local_path)->extractTo(storage_path(self::XML_PATH));

        $this->file_name = rtrim($this->file_name, '.zip');

    }

    public function xmlPath(): string {
        return self::XML_PATH . '/' . $this->file_name;
    }


    public function parse(){

        $job = new ImportActorsAndMandatesJob($this);
        $job->handle();
    }

    public static function importJobList(): Collection{
        return collect([
            'ImportActorsAndMandatesJob'    => ImportActorsAndMandatesJob::class,
            'ImportVotesJob'                => ImportVotesJob::class,
            'ImportLegislativeFoldersJob'   => ImportLegislativeFoldersJob::class,
            'ImportAmendmentJob'            => ImportAmendmentJob::class,
        ]);
    }

    public function newJob(){
        $jobClass = self::importJobList()->get($this->import_script);
        $job =  new $jobClass($this);
        dispatch($job);
    }
}
