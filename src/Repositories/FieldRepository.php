<?php

namespace Mayrajp\Forms\Repositories;

use Mayrajp\Forms\Models\Field;

class FieldRepository 
{
    public function getFieldWithFields(int $dynamicFormId, array $fields = [])
    {
        return Field::select($fields)->where('id', $dynamicFormId)->get();
    }
}