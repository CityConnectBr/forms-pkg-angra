<?php

namespace Mayrajp\Forms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->method() == 'PUT' || $this->method() == 'PATCH')
        {
            return [
                'form_id' => 'required',
                'label' => 'required|min:3|max:255',
                'type' => 'required|min:3|max:255',
                'class' => 'required|min:3|max:255',
                'is_required' => 'required|boolean',
                'is_multiple' => 'required|boolean',
                'options' => 'nullable',
            ];
        }
        
        $rules =  [
            'form_id' =>'required',
            'fields' => 'required|array',
        ];

        foreach($this->get('fields') as $key => $val){
            $rules['fields.'.$key.'.form_id'] = 'required';
            $rules['fields.'.$key.'.label'] = 'required|min:3|max:255';
            $rules['fields.'.$key.'.type'] = 'required|min:3|max:255';
            $rules['fields.'.$key.'.class'] = 'required|min:3|max:255';
            $rules['fields.'.$key.'.is_required'] = 'required|boolean';
            $rules['fields.'.$key.'.is_multiple'] = 'required|boolean'; 
            $rules['fields.'.$key.'.options'] = 'nullable'; 

        }
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
