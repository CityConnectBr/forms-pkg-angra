<?php

namespace Mayrajp\Forms\Services;

use Mayrajp\Forms\Models\DynamicForm;

class DynamicFormService
{

    public function create(array $data): DynamicForm
    {
        $newDynamicForm = DynamicForm::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_by' => $data['created_by'],
            'is_active' => true,
        ]);

        return $newDynamicForm;
    }

    public function update(DynamicForm $dynamicForm, array $data): DynamicForm
    {
        $dynamicForm->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_by' => $data['created_by'],
        ]);
        
        return $dynamicForm;
    }

    public function destroy(DynamicForm $dynamicForm) : void
    {
        $fields = $dynamicForm->fields();

        if($fields){

            foreach($fields as $field){
                $field->is_active = false;
                $field->save();
            }
        }

        $dynamicForm->is_active = false;
        $dynamicForm->save();
    }
}
