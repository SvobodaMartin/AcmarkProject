<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;




class Acmark extends Model
{
    public $table = "acmark";

    protected $fillable = [
        'ico','name','activityDsc','activityCode','created_at','updated_at',
    ];
}
