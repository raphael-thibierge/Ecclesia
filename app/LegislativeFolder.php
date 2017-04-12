<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class LegislativeFolder extends Model
{

    protected $collection = 'legislative_folders';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'title',
        'url',
        'parliamentaryProcedureCode',
        'parliamentaryProcedureTitle',
    ];


    public function acts(){
        return $this->embedsMany('App\LegislativeAct');
    }

}
