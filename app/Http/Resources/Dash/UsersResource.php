<?php

namespace App\Http\Resources\Dash;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Manage\BaseController;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $type = 'user';
        if ($this->type === 2) $type = 'admin';
        elseif ($this->type === 3) $type = 'hall_manager';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $type,
            'hall' => $this->type === 3 ? $this->hall ? new HallsResource($this->hall) : '' : '',
            'token' => $this->token,
        ];
    }
}
