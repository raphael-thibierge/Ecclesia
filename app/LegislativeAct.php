<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class LegislativeAct extends Model
{

    protected $collection = 'legislative_acts';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'legislative_folder_uid',
        'actCode',
        'title',
        'organ_uid',
        'date',
    ];

    protected $dates = ['date'];

    public function organ(){
        return $this->belongsTo('App\Organ', 'organ_uid', 'uid');
    }
}
