<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class Organ extends Model
{

    protected $collection = 'organs';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'type',
        'title',
        'edition_title',
        'short_title',
        'legislative_documents_uids'
    ];


    public function mandates(){
        return $this->hasMany('App\Mandate');
    }

    public function legislative_documents(){
        return $this->belongsToMany('App\LegislativeDocument', null, 'legislative_documents_uids', 'author_organ_uids' );
    }
}
