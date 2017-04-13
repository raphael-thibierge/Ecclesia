<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Actor extends Eloquent
{

    protected $table = 'actors';
    protected $collection = 'actors';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $dates = ['birth_date', 'death_date'];

    protected $fillable = [
        'uid',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'birth_department', // can be null
        'birth_country', // can be null
        'death_date', // can be null
        'legislative_document_uids'
    ];

    public function mandates(){
        return $this->hasMany('\App\Mandate');
    }


    public function ballots(){
        return $this->hasMany('App\Ballot');
    }

    public function legislative_documents(){
        return $this->belongsToMany('App\LegislativeDocument', null, 'legislative_documents_uids', 'author_actor_uids' );
    }

    public function amendments_as_author(){
        return $this->hasMany('App\Amendment', 'author_uid', 'uid');
    }

    public function amendments_as_co_author(){
        return $this->hasMany('App\Amendment', 'co_author_uid', 'uid');
    }
}
