<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
                    'company_name' => $this->company,
                    'company_address_id' => $this->company_address_id,
                    'telephone' => $this->phoneNumber,
                    'email' => $this->safeEmail,
                    'website' => $this->url
            ];
        }
    }
}
