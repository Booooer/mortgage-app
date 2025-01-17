<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'deal_id'                 => 'required|integer',
            'task_type'               => 'required|string',
            'wished_sum'              => 'required|integer',
            'have_init_payment'       => 'required|boolean',
            'borrower_type'           => 'required|string',
            'contact_uid'             => 'required|uuid',
            'employment_type'         => 'required|string',
            'bank_salary'             => 'required|string',
            'marital_status'          => 'required|string',
            'have_children'           => 'required|boolean',
            'phone_uid'               => 'required|uuid',
            'mortgage_type_uid'       => 'required|uuid',
            'live_complex_uid'        => 'required|uuid',
            'init_payment_source_uid' => 'uuid',
            'init_payment'            => 'integer',
            'comment'                 => 'string',
            'maternity_capital'       => 'integer',
            'docs'                    => 'file|max:15000',
        ];
    }
}
