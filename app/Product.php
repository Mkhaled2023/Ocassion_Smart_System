<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

  protected $fillable = [
      'name' , 'price' , ' location' , 'type' , 'Rate' , 'images' , 'images_profile' , 'catgoery'
    ];
}

