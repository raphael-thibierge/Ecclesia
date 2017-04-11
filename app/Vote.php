<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class Vote extends Model
{

    protected $table = 'votes';
    protected $collection = 'votes';

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $fillable = [
        'uid',
        'number',
        'date',
        'decision',
        'applicant',
        'title',
        'description',
        'object',
    ];



}
