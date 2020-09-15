<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RecruiterCollection;
use App\Http\Resources\RecruiterResource;
use App\Recruiter;
use App\Permission;
use App\Http\Requests\StoreRecruiter;
use App\Http\Requests\UpdateRecruiter;
use Illuminate\Support\Facades\DB;

class RecruitersController extends Controller
{
    /**
     * Return a collection of Recruiters.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Access To All Recruiters" && $permission->active == true)
            {
                return new RecruiterCollection(Recruiter::all());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRecruiter  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecruiter $request)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create New Recruiter" && $permission->active == true)
            {
                $Recruiter = Recruiter::create($request->validated());
                return $Recruiter;
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
        if ($permissions) {
            foreach($permissions as $permission) {
                if ($permission->description == "Allow Access To Recruiter" && $permission->active == true)
                {
                    return new RecruiterResource(Recruiter::where('id',$id)->firstOrFail());
                }
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
    public function update(UpdateRecruiter $request, $id)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Update Recruiter" && $permission->active == true)
            {
                $Recruiter = Recruiter::findOrFail($id);
                $Recruiter->update($request->validated());
                return $Recruiter;
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Delete Recruiter" && $permission->active == true)
            {
                $Recruiter = Recruiter::findOrFail($id);
                $result = $Recruiter->delete();
                return response()->json(["success" => $result]);
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);
    }
}
