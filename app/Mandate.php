<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $attributes = [
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
