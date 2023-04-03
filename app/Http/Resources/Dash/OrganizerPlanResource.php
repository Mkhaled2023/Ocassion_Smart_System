<?php

namespace App\Http\Resources\Dash;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Controllers\Manage\BaseController;

class OrganizerPlanResource extends JsonResource
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
            'image' => BaseController::getImageUrl('Organizers',$this->image),
            'image_profile' => BaseController::getImageUrl('Organizers',$this->image_profile),
            'offer_name' => $this->offer_name,
            'offer_description' => $this->offer_description,
            'price' => $this->price,
        ];
    }
}
