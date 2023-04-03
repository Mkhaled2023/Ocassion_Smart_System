<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name' , 'image' , 'date_time' , ' address' , 'about' , 'price' , 'typeof' , 'duration'
    ];
}
