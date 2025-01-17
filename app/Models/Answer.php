<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = "answers";
    protected $guarded = ['id'];

    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function respondent(){
        return $this->belongsTo(Respondent::class, 'respondent_id');
    }
}
