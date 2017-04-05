<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class OpenDataFile extends Model
{

    protected $table = 'open_data_files';

    protected $primaryKey = 'id';


    protected $fillable = ['name', 'url', 'description'];

}
