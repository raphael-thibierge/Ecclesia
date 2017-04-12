<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class LegislativeDocument extends Model
{
    protected $collection = 'legislative_documents';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'title',
        'classificationTypeCode',
        'classificationTypeTitle',
        'classificationUnderTypeCode',
        'classificationUnderTypeTitle',
        'adoptionStatus',
        'creation_date',
        'deposit_date',
        'publish_date',
        'author_actor_uids',
        'author_organ_uids',
    ];

    protected $dates = [
        'creation_date',
        'deposit_date',
        'publish_date',
    ];


    public function author_actors(){
        return $this->belongsToMany('App\Actor', null, 'author_actor_uids', 'legislative_documents_uids');
    }

    public function author_organs(){
        return $this->belongsToMany('App\Actor', null, 'author_organ_uids', 'legislative_documents_uids');
    }



}
