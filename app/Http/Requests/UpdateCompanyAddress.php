<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyAddress extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'name' => 'string|max:255',
        'address_one' => 'string|max:255',  
        'address_two' => 'nullable|string|max:255',
        'address_three' => 'nullable|string|max:255',
        'city' => 'string|max:255',
        'state' => 'string|max:255',
        'post_code' => ['string','regex:/([Gg][Ii][Rr] 0[Aa]{2})|((([A-Za-z][0-9]{1,2})|
        (([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9]
        [A-Za-z]?))))\s?[0-9][A-Za-z]{2})/'],
        ];
    }
}
