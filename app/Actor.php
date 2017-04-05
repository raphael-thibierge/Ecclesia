<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{

    protected $primaryKey = 'uid';

    public $incrementing = false;

    protected $attributes = [
        'firstname',
        'lastname',
        'gender',
        'birth_date',
        'birth_department', // can be null
        'birth_country', // can be null
        'death_date', // can be null
    ];

    public function mandates(){
        return $this->hasMany('\App\Actors');
    }

}
