<?php

namespace App\Models\Dash;

use Illuminate\Database\Eloquent\Model;

class OrganizePlans extends Model
{
    protected $table = 'offers';

    protected $fillable = [
        'name' , 'image' , ' image_profile' , 'offer_name' ,
        'offer_description' , 'price' , 'date_time', 'teamid'
    ];

    public function organizer() {
        return $this->belongsTo(Organizers::class, 'teamid');
    }
}
