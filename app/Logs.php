<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Logs extends Model
{

    protected $connection = 'mongodb';
    protected $table = 'logs';
    protected $collection = 'logs';
    
    protected $fillable = [
        'text', 'time'
    ];
    
    
}
