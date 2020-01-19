<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Question extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
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
        ];
    }
}
