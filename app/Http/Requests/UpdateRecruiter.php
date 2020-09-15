<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecruiter extends FormRequest
{
       /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'max:255|string',
            'last_name' => 'max:255|string',
            'email' => 'unique:recruiters,email|email',
            'email_verified_at' => 'nullable',
            'password' => 'string',
            'remember_token' => 'nullable',
            'telephone' => 'string',
            'company_address_id' => 'integer',
            'job_title' => 'string',
            'mobile' => 'string',
            'dob' => 'date',
            'role_id' => 'integer'
        ];
    }
}
