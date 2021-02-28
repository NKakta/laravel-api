<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateListItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'game_id' => ['required', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'game_id.required' => 'Game is required',
            'game_id.integer' => 'Game must be integer',
        ];
    }
}
