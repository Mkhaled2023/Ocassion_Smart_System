<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model;

class Halls extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name' , 'price' , ' location' , 'Rate' , 'images' , 'images_profile' , 'catgoery'
    ];
}
