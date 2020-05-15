<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecruiter extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'email' => 'required|unique:recruiters,email|email',
            'email_verified_at' => 'present',
            'password' => 'required|string',
            'remember_token' => 'present',
            'telephone' => 'required|string',
            'company_address_id' => 'required|integer',
            'job_title' => 'required|string',
            'mobile' => 'required|string',
            'role_id' => 'required|integer',
            'company_id' => 'required|integer'
        ];
    }
}
