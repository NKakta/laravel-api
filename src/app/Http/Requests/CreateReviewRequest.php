<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    public function rules()
    {
        return [
            'game_id' => ['required', 'integer'],
            'title' => ['string', 'nullable'],
            'content' => ['string', 'nullable'],
            'positive' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'game_id.required' => 'Game is required',
            'game_id.integer' => 'Game must be integer',
            'content.required' => 'Content is required',
            'content.integer' => 'Content must be text',
            'title.required' => 'Title is required',
            'title.integer' => 'Title must be text',
            'positive.required' => 'Positive is required',
            'positive.integer' => 'Positive must be integer',
        ];
    }
}
