<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|distinct|min:1',
            'billing_first_name' => 'required|string|max:225',
            'billing_last_name' => 'required|string|max:255',
            'billing_company' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_postcode' => 'required|string',
            'billing_country' => 'required|string',
            'billing_email' => 'required|string|email',
            'customer_name' => 'required|string',
            'shipping_first_name' => 'required|string',
            'shipping_last_name' => 'required|string',
            'shipping_company' => 'required|string',
            'shipping_address_1' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_postcode' => 'required|string',
            'shipping_country' => 'required|string',
            'shipping_email' => 'required|string|email',
            'shipping_phone' => 'required|string'
        ];
    }
}
