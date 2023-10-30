<?php

namespace App\Http\Requests\Order;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::id() === $this->route('order.user_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_id' => 'required|numeric',
            'payment_method' => Rule::in(PaymentMethod::$types),
        ];
    }

    public function messages()
    {
        return [
            'contact_id.required' => trans('contact.validation.id.required'),
        ];
    }
}
