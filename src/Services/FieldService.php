<?php

namespace Mayrajp\Forms\Services;

use Mayrajp\Forms\Models\DynamicForm;
use Mayrajp\Forms\Models\Field;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FieldService
{
    public function create(DynamicForm $dynamicForm, array $data)
    {
        try {

            foreach ($data['fields'] as $field) {

                $dynamicForm->fields()->create([
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'class' => $field['class'],
                    'is_required' => $field['is_required'],
                    'is_multiple' => $field['is_multiple'],
                    'options' => json_encode($field['options']),
                    'is_active' => true,
                ]);
            }
        } catch (Exception $exception) {
            
            $dynamicForm->fields()->delete();

            throw new HttpException(500, $exception->getMessage());
        }


        return $dynamicForm;
    }

    public function update(Field $field, DynamicForm $dynamicForm, array $data)
    {
        $is_modified = $this->fieldHasBeenModified($field, $data);


        if ($is_modified) {
            $dynamicForm->fields()->create([
                'label' => $data['label'],
                'type' => $data['type'],
                'class' => $data['class'],
                'is_required' => $data['is_required'],
                'is_multiple' => $data['is_multiple'],
                'options' => json_encode($data['options']),
                'is_active' => true,
            ]);

            $field->is_active = false;

            $field->save();
        } else {

            $field->update([
                'label' => $data['label'],
                'type' => $data['type'],
                'class' => $data['class'],
                'is_required' => $data['is_required'],
                'is_multiple' => $data['is_multiple'],
                'options' => json_encode($data['options']),
                'is_active' => true,
            ]);
        }
    }

    private function fieldHasBeenModified(Field $field, array $data): bool
    {

        if ($field->label != $data['label']) {
            return true;
        }

        if ($field->type != $data['type']) {
            return true;
        }

        return false;
    }
}
