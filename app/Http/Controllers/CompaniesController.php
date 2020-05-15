<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;
use App\Company;
use App\Recruiter;

class CompaniesController extends Controller
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
            if ($permission->description == "Allow Access To All Companies" && $permission->active == true)
            {
                return new CompanyCollection(Company::all());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCompany  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompany $request)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create Company" && $permission->active == true)
            {
                $Company = Company::create($request->validated());
                return $Company;
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
            if ($permission->description == "Allow Access To Specific Company" && $permission->active == true)
            {
                return new CompanyResource(Company::where('id',$id)->firstOrFail());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\UpdateCompany  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompany $request, $id)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Edit Company" && $permission->active == true)
            {
                $Company = Company::findOrFail($id);
                $Company->update($request->validated());
                return $Company;
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
            if ($permission->description == "Allow Delete Company" && $permission->active == true)
            {
                $Company = Company::findOrFail($id);
                $result = $Company->delete();
                return response()->json(["success" => $result]);
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401); 
    }
}
