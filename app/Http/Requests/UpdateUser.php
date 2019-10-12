<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            "full_name" => 'required|string|max:255',
            "birthday_date" => 'nullable|date',
            "user_type_id" => 'exists:user_type,id|required',
            "role" => 'required|array|min:1'
        ];
    }
}
