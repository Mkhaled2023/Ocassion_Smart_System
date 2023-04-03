<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model;

class Organizers extends Model
{
    protected $table = 'aboutorgaizes';

    protected $fillable = [
        'name', 'image', 'about', 'imageprofile'
    ];

    public function plan(){
        return $this->hasOne(OrganizePlans::class, 'teamid');
//        return $this->hasMany(OrganizePlans::class, 'teamid');

    }
}
