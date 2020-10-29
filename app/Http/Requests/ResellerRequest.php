<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResellerRequest extends FormRequest
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
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|unique:users',
                    'number' => 'required|string|max:13',
                    'city' => 'required|string',
                    'password' => 'required|string|confirmed'
                ];
            case 'PATCH':
                return [
                    'name' => 'required|string|max:255'
                ];
            case 'DEFAULT':
                return [];       
        }
    }
}
