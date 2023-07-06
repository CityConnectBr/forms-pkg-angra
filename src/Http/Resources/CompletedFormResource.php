<?php

namespace Mayrajp\Forms\Http\Resources;

use App\Models\DynamicForm;
use App\Repositories\DynamicFormRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class CompletedFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $reporitory  = new DynamicFormRepository();
        return [
            'id' => $this->id,
            'dynamicForm' => $reporitory->getDynamicFormWithFields($this->dynamicForm->id, ['id', 'name', 'description']),
            'user_id' => $this->user_id,
            'expires_in' => $this->expires_in,
            'answers' => AnswareResource::collection($this->answers),
        ];
    }
}
