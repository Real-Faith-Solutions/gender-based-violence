<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'user_last_name' => 'required',
            'user_first_name' => 'required',
            'user_middle_name' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Fields is required!'
        ];
    }
}
