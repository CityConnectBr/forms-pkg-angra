<?php

namespace Mayrajp\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicForm extends Model
{
    use HasFactory;

    protected $table = 'dynamic_forms';

    protected $fillable = ['name', 'description','created_by', 'is_active'];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function completedForms()
    {
        return $this->hasMany(CompletedForm::class);
    }
}
