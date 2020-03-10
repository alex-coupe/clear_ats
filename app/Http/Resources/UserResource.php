<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                    "firstname" => $this->first_name,
                    "lastname" => $this->last_name,
                    "email" => $this->email,
                    "emailverified" => $this->email_verified_at,
                    "jobtitle" => $this->job_title,
                    "telephone" => $this->telephone,
                    "mobile" => $this->mobile,
                    "dob" => $this->dob,
                    "location" => $this->location,
                    "roles" => $this->roles,
                    "brands" => $this->brands
            ];
        }

    }

}
