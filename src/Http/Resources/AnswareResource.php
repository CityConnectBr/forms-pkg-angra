<?php

namespace Mayrajp\Forms\Http\Resources;

use App\Models\Field;
use App\Repositories\FieldRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $repository = new FieldRepository();
        return [
            'id' => $this->id,
            'field' => $repository->getFieldWithFields($this->field_id,['id','label', 'type', 'class', 'is_required', 'is_multiple', 'options']),
            'answer' => json_decode($this->answare),
        ];
    }
}
