<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Candidate extends Model
{
    protected $guarded = [];

    protected $table = "candidates";

    public function applications()
    {
        return $this->belongsToMany('App\Application');
    }

    public static function getCandidatesByCompanyId($companyId)
    {
        return DB::table('candidates')
        ->join('recruiters', 'candidates.recruiter_id', '=', 'recruiters.id')
        ->where('recruiters.company_id', '=', $companyId)
        ->get();
    }

    public static function getCandidateByCompanyId($companyId, $candidateId)
    {
        return DB::table('candidates')
        ->join('recruiters', 'candidates.recruiter_id', '=', 'recruiters.id')
        ->where('candidates.id', '=', $candidateId)
        ->where('recruiters.company_id', '=', $companyId)
        ->first();
    }
}
