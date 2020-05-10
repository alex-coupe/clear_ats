<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'email' => 'unique:users,email|email',
            'email_verified_at' => 'nullable',
            'password' => 'string',
            'remember_token' => 'nullable',
            'telephone' => 'string',
            'location_id' => 'integer',
            'job_title' => 'string',
            'mobile' => 'string',
            'dob' => 'date',
            'role_id' => 'integer'
        ];
    }
}
