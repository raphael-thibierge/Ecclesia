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


    /**
     * Copy remote file over HTTP one small chunk at a time.
     *
     * @param $infile The full URL to the remote file
     * @param $outfile The path where to save the file
     * @return bool|int
     */
    private static function copyfile_chunked($infile, $outfile) {
        $chunksize = 10 * (1024 * 1024); // 10 Megs

        /**
         * parse_url breaks a part a URL into it's parts, i.e. host, path,
         * query string, etc.
         */
        $parts = parse_url($infile);
        $i_handle = fsockopen($parts['host'], 80, $errstr, $errcode, 5);
        $o_handle = fopen($outfile, 'wb');

        if ($i_handle == false || $o_handle == false) {
            return false;
        }

        if (!empty($parts['query'])) {
            $parts['path'] .= '?' . $parts['query'];
        }

        /**
         * Send the request to the server for the file
         */
        $request = "GET {$parts['path']} HTTP/1.1\r\n";
        $request .= "Host: {$parts['host']}\r\n";
        $request .= "User-Agent: Mozilla/5.0\r\n";
        $request .= "Keep-Alive: 115\r\n";
        $request .= "Connection: keep-alive\r\n\r\n";
        fwrite($i_handle, $request);

        /**
         * Now read the headers from the remote server. We'll need
         * to get the content length.
         */
        $headers = array();
        while(!feof($i_handle)) {
            $line = fgets($i_handle);
            if ($line == "\r\n") break;
            $headers[] = $line;
        }

        /**
         * Look for the Content-Length header, and get the size
         * of the remote file.
         */
        $length = 0;
        foreach($headers as $header) {
            if (stripos($header, 'Content-Length:') === 0) {
                $length = (int)str_replace('Content-Length: ', '', $header);
                break;
            }
        }

        /**
         * Start reading in the remote file, and writing it to the
         * local file one chunk at a time.
         */
        $cnt = 0;
        while(!feof($i_handle)) {
            $buf = '';
            $buf = fread($i_handle, $chunksize);
            $bytes = fwrite($o_handle, $buf);
            if ($bytes == false) {
                return false;
            }
            $cnt += $bytes;

            /**
             * We're done reading when we've reached the conent length
             */
            if ($cnt >= $length) break;
        }

        fclose($i_handle);
        fclose($o_handle);
        return $cnt;
    }

    public function download(){


        $fileParts = explode('/', $this->url);
        $this->file_name = $fileParts[count($fileParts)-1];

        $this->local_path = storage_path(self::ZIP_PATH . $this->file_name);


        self::copyfile_chunked($this->url, $this->local_path);

        //exec('wget -o ' . $this->local_path . ' ' . $this->url);

        //$fileContent = file_get_contents($this->url);
        //file_put_contents($this->local_path, $fileContent);

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
