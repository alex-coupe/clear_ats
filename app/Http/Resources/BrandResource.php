<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
                    'brand_name' => $this->company,
                    'location_id' => $this->numberBetween(0,5),
                    'telephone' => $this->phoneNumber,
                    'email' => $this->safeEmail,
                    'website' => $this->url
            ];
        }
    }
}
