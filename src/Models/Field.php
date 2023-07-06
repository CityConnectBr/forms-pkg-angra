<?php

namespace Mayrajp\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'fields';

    protected $fillable = [
        'label', 'type', 'class', 'is_required', 'is_multiple', 'options', 'is_active'
    ];

    public function dynamicForm()
    {
        return $this->belongsTo(DynamicForm::class);
    }
}
