<?php

namespace Mayrajp\Forms\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DynamicFormResource extends JsonResource
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
            'created_by' => $this->created_by,
            'fields' => FieldResource::collection($this->fields),
        ];
    }
}
