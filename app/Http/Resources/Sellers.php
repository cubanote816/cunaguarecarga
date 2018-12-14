<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Sellers extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->user->id,
            'name' => $this->resource->user->name,
            'email' => $this->resource->user->email,
            'role' => $this->resource->user->role,
            'active' => $this->resource->user->active == 1 ? true : false,
            'agreement' => $this->resource->agreement,
        ];
    }
}
