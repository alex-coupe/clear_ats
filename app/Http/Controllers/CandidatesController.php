<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recruiter;
use App\Candidate;
use App\Http\Resources\CandidatesCollection;
use App\Http\Resources\CandidateResource;
use App\Http\Requests\StoreCandidate;


class CandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Access To All Candidates" && $permission->active == true)
            {
                return new CandidatesCollection(Candidate::getCandidatesByCompanyId(auth()->user()->company_id));
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCandidate  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCandidate $request)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create Candidates" && $permission->active == true)
            {
                $candidate = Candidate::create($request->validated());
                $candidate->cv_path = $request->file('cv')->getClientOriginalName();
                $request->file('cv')->storeAs('files',$request->file('cv')->getClientOriginalName() );
                $candidate->cover_path = $request->file('cover')->getClientOriginalName();
                $request->file('cover')->storeAs('files',$request->file('cover')->getClientOriginalName()); 
                $candidate->save();
                return $candidate;
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Access To Specific Candidate" && $permission->active == true)
            {
                return new CandidateResource(Candidate::getCandidateByCompanyId(auth()->user()->company_id,$id));
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
