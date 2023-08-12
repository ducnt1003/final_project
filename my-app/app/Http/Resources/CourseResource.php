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
            'level_name' => $this->getLevel($this->level),
            'price' => $this->price ? $this->price : 0,
            'description' => $this->description,
            'parts' => $this->parts ? new CoursePartCollection($this->parts) : null,
            'teacher' => $this->teacher->user,
            'teacher_name' => $this->teacher->user->name,
            'image' => $this->photo ? env('APP_URL').'/'.$this->photo : env('APP_URL').'/'.'thumbnail_placeholder.png',
            'number_parts' => $this->parts->count(),
            'number_enrolls' => $this->enrolls->count(),
        ];
    }
}
