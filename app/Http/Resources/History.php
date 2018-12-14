<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class History extends JsonResource
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
            // 'sold_by' => $this->resource->user,
            'contractor' => $this->resource->user->contractors,
            'hired' => $this->resource->user->hired,
            'soldBy' => (string) $this->resource->user->name,
            // 'soldBy' => [
            //     'name' => (string) $this->resource->user->name,
            //     'role' => $this->resource->user->role,
            // ],
            'createdAt' => (string) $this->resource->created_at,
            // 'created_at' => Carbon::createFromFormat('d/m/Y', $this->created_at),
        ];
    }
}
