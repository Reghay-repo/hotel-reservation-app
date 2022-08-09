<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required|max:255',
            'job' => 'required',
            'cni' => 'required',
            'phone_number' => 'required',
            'passport_num' => 'required',
            'code_bank' => 'required',
            'birthdate' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'email' => 'required|unique:users,email',
        ];
    }
}
