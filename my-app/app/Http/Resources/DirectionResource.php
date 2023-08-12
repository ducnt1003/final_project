<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DirectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'expert' => $this->expert->user,
            'expert_name' => $this->expert->user->name,
            'interested' => $this->student_directions->count(),
            'rules' => $this->Rule,
        ];
    }
}
