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
    ];


    public function mandates(){
        return $this->hasMany('App\Mandate');
    }
}
