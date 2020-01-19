<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $userAnswer;


    public function setUserAnswerAttribute($value)
    {
        $this->userAnswer = $value;
    }

    public function getUserAnswerAttribute()
    {
        return $this->userAnswer;
    }

    public function toDTO()
    {
        return [
            "id" => $this->id,
            "text" => $this->text,
            "answerA" => $this->answerA,
            "answerB" => $this->answerB,
            "answerC" => $this->answerC,
            "answerD" => $this->answerD,
            "correctAnswer" => $this->correctAnswer,
            "category" => $this->category,
            "language" => $this->language,
            "added_by_user" => $this->added_by_user,
            "userAnswer" => $this->userAnswer,
        ];
    }
}
