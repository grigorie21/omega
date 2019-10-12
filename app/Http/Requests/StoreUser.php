<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            "organization" => 'required|string',
            "user_type_id" => 'exists:user_type,id|required',
            "role" => 'required|array|min:1'
        ];
    }
}
