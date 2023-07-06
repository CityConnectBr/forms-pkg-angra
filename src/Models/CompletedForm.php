<?php

namespace Mayrajp\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedForm extends Model
{
    use HasFactory;

    protected $table = 'completed_forms';

    protected $fillable = ['user_id', 'expires_in'];

    public function dynamicForm()
    {
        return $this->belongsTo(DynamicForm::class);
    }

    public function answers()
    {
        return $this->hasMany(Answare::class);
    }
}
