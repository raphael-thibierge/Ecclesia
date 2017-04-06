<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;

class Mandate extends MongoModel
{

    protected $table = 'mandates';
    protected $collection = 'mandates';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'actor_uid',
        'organ_type',
        'start_date',
        'end_date', // can be null
        'taking_office_date', // can be null
        'quality', // can be null
    ];


    public function actor(){
        return $this->belongsTo('App\Actor');
    }

}
