<?php

namespace App\Http\Requests\Orders;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrdersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "customer_name" => ['required', 'string', 'max:255'],
            "customer_phone" => ['required', 'string', 'max:20'],
            "customer_email" => ['required', 'email'],

            "zip_code" => ['required', 'string', 'max:20'],
            "street" => ['required', 'string', 'max:255'],
            "number" => ['required', 'string', 'max:20'],
            "district" => ['required', 'string', 'max:255'],
            "city" => ['required', 'string', 'max:255'],
            "state" => ['required', 'string', 'max:255'],
            "complement" => ['nullable', 'string', 'max:255'],
            "reference" => ['nullable', 'string', 'max:255'],
            "payment_method" => ['required', 'string', 'in:cash,credit_card,debit_card,pix'],
            "change_for" => ['required_if:payment_method,cash', 'nullable', 'numeric', 'min:0'],
            "subtotal" => ['required', 'numeric', 'min:0'],
            "delivery_fee" => ['required', 'numeric', 'min:0'],
            "total" => ['required', 'numeric', 'min:0']
    ];
    }
}
