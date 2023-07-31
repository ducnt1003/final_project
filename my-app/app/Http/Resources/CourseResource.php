<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'category' => $this->category->name,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'price' => $this->price,
            'description' => $this->description,
            'parts' => $this->parts,
            'teacher' => $this->teacher->user,
            'image' => $this->photo ? env('APP_URL').'/'.$this->photo : env('APP_URL').'/'.'thumbnail_placeholder.png',
        ];
    }
}
