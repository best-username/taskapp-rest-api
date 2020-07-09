<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'image_desktop' => $this->image_desktop,
            'image_mobile' => $this->image_mobile,
            'status' => $this->status,
            'creator' => new UserResource(User::find($this->creator_id)),
            'boards' => BoardResource::collection($this->boards),
            'labels' => LabelResource::collection($this->labels)
        ];
    }
}
