<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'required|alpha_num',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required', // @todo unique:cities
            'country' => 'required', // @todo unique:countries
            'zip_code' => 'required|integer|digits:5',
            'about' => 'required',
        ];
    }
}
