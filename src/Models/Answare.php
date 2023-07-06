<?php

namespace Mayrajp\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answare extends Model
{
    use HasFactory;

    protected $table = 'answare';

    protected $fillable = ['answare', 'field_id'];

    public function completedForm()
    {
        return $this->belongsTo(CompletedForm::class);
    }

}
