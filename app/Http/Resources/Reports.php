<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Reports extends JsonResource
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
            'phone' => (string) $this->resource->phone,
            'cost' => $this->resource->cost,
            'status' => $this->resource->status,
            'type' => $this->resource->type,
            'createdAt' => (string) $this->resource->created_at,
        ];
    }
}
