<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'email' => 'required|unique:users,email|email',
            'email_verified_at' => 'present',
            'password' => 'required|string',
            'remember_token' => 'present',
            'telephone' => 'required|string',
            'location_id' => 'required|integer',
            'job_title' => 'required|string',
            'mobile' => 'required|string',
            'dob' => 'required|date',
            'role_id' => 'required|integer'
        ];
    }
}
