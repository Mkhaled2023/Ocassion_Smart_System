<?php

namespace App\Http\Resources\Dash;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Controllers\Manage\BaseController;

class HallsResource extends JsonResource
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
            'price' => $this->price,
            'location' => $this->location,
            'Rate' => $this->Rate,
            'images' => BaseController::getImageUrl('Halls',$this->images),
            'images_profile' => BaseController::getImageUrl('Halls',$this->images_profile),
            'category' => $this->catgoery,
        ];
    }
}
