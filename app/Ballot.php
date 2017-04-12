<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class Ballot extends Model
{

    protected $collection = 'ballots';

    protected $primaryKey = '_id';

    protected $fillable = [
        'vote_uid',
        'actor_uid',
        'mandate_uid',
        'decision',
    ];

    public function actor(){
        return $this->belongsTo('App\Actor', 'actor_uid', 'uid');
    }

    public function mandate(){
        return $this->belongsTo('App\Mandate', 'mandate_uid', 'uid');
    }

    public function vote(){
        return $this->belongsTo('App\Vote', 'vote_uid', 'uid');
    }




}
