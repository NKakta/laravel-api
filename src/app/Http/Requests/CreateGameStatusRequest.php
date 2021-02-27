<?php

namespace App\Http\Requests;

use App\Models\GameStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;


class CreateGameStatusRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'string', Rule::in(GameStatus::STATUSES)],
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status is required',
            'status.string' => 'Status must be string',
            'status.in' => 'Invalid status',
        ];
    }
}
