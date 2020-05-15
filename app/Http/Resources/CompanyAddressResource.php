<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource != null)
        {
            return [
                    "id" => $this->id,
                    "name" => $this->name,
                    "addressone" => $this->address_one,
                    "addresstwo" => $this->address_two,
                    "addressthree" => $this->address_three,
                    "city" => $this->city,
                    "state" => $this->state,
                    "postcode" => $this->post_code,
            ];
        }
    }
}
