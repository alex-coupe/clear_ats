<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCandidate extends FormRequest
{
  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string|required',
            'email' => 'email|required|max:250',
            'last_name' => 'string|required',
            'recruiter_id' => 'integer|required',       
            'current_salary' => 'digits|nullable',
            'expected_salary' => 'digits|nullable',
            'current_role' => 'string|nullable',
            'current_sector_id' => 'integer|nullable',
            'cv_path' => 'file',
            'cover_path' => 'file|nullable'
        ];
    }
}
