<?php

namespace Mayrajp\Forms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CompletedFormRequest extends FormRequest
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
            $rules =  [
                'answers' => 'required|array',
            ];

            foreach($this->get('answers') as $key => $val){
                $rules['answers.'.$key.'.id'] = 'required';
                $rules['answers.'.$key.'.field_id'] = 'required|exists:fields,id';
                $rules['answers.'.$key.'.answare'] = 'required|array';
            }

            return $rules;
        }
        
        $rules =  [
            'dynamic_form_id' => 'required|exists:dynamic_forms,id',
            'user_id' => 'required',
            'expires_in' => 'required',
            'answers' => 'required|array',
        ];

        foreach($this->get('answers') as $key => $val){
            $rules['answers.'.$key.'.field_id'] = 'required|exists:fields,id';
            $rules['answers.'.$key.'.answare'] = 'required|array';
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
