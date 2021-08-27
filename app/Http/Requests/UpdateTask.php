<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTask extends FormRequest
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
            'name' => 'min:2|max:255',
            'description' => 'string',
            'deadline_date' => 'date',
            'user_id' => 'exists:App\User,id',
            'status_id' => 'exists:App\Status,id'
        ];
    }
}
