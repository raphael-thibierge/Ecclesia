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

    protected $fillable = [
        'uid',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'birth_department', // can be null
        'birth_country', // can be null
        'death_date', // can be null
    ];

    public function mandates(){
        return $this->hasMany('\App\Mandate');
    }

}
