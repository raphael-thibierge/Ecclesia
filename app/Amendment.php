<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class Amendment extends Model
{
    protected $collection = 'amendments';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'legislative_document_uid',
        'text_step',
        'amendment_sorting',
        'state',
        'author_uid',
        'co_author_uid',
        'text_fragment_pointer_title',
        'text_fragment_pointer_short_title',
        'content',
        'content_summary',
        'decision',
        'decision_date',
        'deposit_date',
        'distribution_date',
    ];

    protected $dates = [
        'decision_date',
        'deposit_date',
        'distribution_date',
    ];


    public function author(){
        return $this->belongsTo('App\Actor', 'author_uid', 'uid');
    }

    public function co_author(){
        return $this->belongsTo('App\Actor', 'co_author_uid', 'uid');
    }

    public function legislative_document(){
        return $this->belongsTo('App\LegislativeDocument', 'legislative_document_uid', 'uid');
    }

}
