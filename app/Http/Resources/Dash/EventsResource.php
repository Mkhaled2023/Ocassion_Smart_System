<?php

namespace App\Http\Resources\Dash;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Controllers\Manage\BaseController;

class EventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = $request->header('lang');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => BaseController::getImageUrl('Halls',$this->images),
            'date_time' => $this->date_time,
            'address' => $this->address,
            'about' => $this->about,
            'price' => $this->price,
            'typeof' => $this->typeof,
            'duration' => $this->duration,
        ];
    }
}
