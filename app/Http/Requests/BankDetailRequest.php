<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankDetailRequest extends FormRequest
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
                    'account_title' => 'required|string|max:255',
                    'account_number' => 'required|string|max:255|unique:bank_details',
                    'bank_name' => 'required|string|max:255'
                ];
            case 'PATCH':
                return [
                    'account_title' => 'required|string|max:255',
                    'account_number' => 'required|string|max:255',
                    'bank_name' => 'required|string|max:255'
                ];
            case 'DEFAULT':
                return [];
        }
    }
}
