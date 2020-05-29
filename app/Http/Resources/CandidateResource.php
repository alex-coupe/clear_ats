<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
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
                'id' => $this->id,
                'first_name' => $this->first_name,
                'email' => $this->email,
                'last_name' => $this->last_name,
                'cv_path' => $this->cv_path,
                'cover_path' => $this->cover_path,
                'recruiter_id' => $this->recruiter_id,
                'introductory_contact_complete' => $this->introductory_contact_complete,
                'current_salary' => $this->current_salary,
                'expected_salary' => $this->expected_salary,
                'current_role' => $this->current_role,
                'current_sector_id' => $this->current_sector_id,
                'notes' => $this->notes,
                'deleted' => $this->deleted
            ];
        }
    }
}
