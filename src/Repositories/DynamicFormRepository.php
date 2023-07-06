<?php

namespace Mayrajp\Forms\Repositories;

use Mayrajp\Forms\Models\DynamicForm;

class DynamicFormRepository 
{
    public function getDynamicFormWithFields(int $dynamicFormId, array $fields = [])
    {
        return DynamicForm::select($fields)->where('id', $dynamicFormId)->get();
    }
}