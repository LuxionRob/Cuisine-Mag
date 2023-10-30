<?php

namespace App\Http\Requests\Authorized\Order;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AuthorizedOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->role === UserRole::ROLE_ADMIN || Auth::user()->role === UserRole::ROLE_SALESMAN) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => Rule::in(OrderStatus::$available_status),
        ];
    }

    public function messages()
    {
        return [
            'contact_id.in' => trans('order.validation.status.notAbleCancel'),
        ];
    }
}
