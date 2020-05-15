<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyAddressCollection;
use App\Http\Resources\CompanyAddressResource;
use App\CompanyAddress;
use App\Http\Requests\StoreCompanyAddress;
use App\Http\Requests\UpdateCompanyAddress;
use App\Recruiter;

class CompanyAddressesController extends Controller
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
            if ($permission->description == "Allow Access To All Company Addresses" && $permission->active == true)
            {
                return new CompanyAddressCollection(CompanyAddress::all());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCompanyAddress  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyAddress $request)
    {
        
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create Company Address" && $permission->active == true)
            {
                $companyAddress = CompanyAddress::create($request->validated());
                return $companyAddress;
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
            if ($permission->description == "Allow Access To Specific Company Address" && $permission->active == true)
            {
                return new CompanyAddressResource(CompanyAddress::where('id',$id)->firstOrFail());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateCompanyAddress  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyAddress $request, $id)
    {
        $permissions = Recruiter::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Edit Company Address" && $permission->active == true)
            {
                $companyAddress = CompanyAddress::findOrFail($id);
                $companyAddress->update($request->validated());
                return $companyAddress;
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
            if ($permission->description == "Allow Delete Company Address" && $permission->active == true)
            {
                $companyAddress = CompanyAddress::findOrFail($id);
                $result = $companyAddress->delete();
                return response()->json(["success" => $result]);
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);    
    }
}
