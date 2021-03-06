<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Location;
use App\Http\Requests\StoreLocation;
use App\Http\Requests\UpdateLocation;
use App\User;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Access To All Locations")
            {
                return new LocationCollection(Location::all());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreLocation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create Location")
            {
                $location = Location::create($request->validated());
                return $location;
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
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Access To Specific Location")
            {
                return new LocationResource(Location::where('id',$id)->firstOrFail());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateLocation  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocation $request, $id)
    {
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Edit Location")
            {
                $location = Location::findOrFail($id);
                $location->update($request->validated());
                return $location;
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
        $permissions = User::GetPermissions(); 
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Delete Location")
            {
                $location = Location::findOrFail($id);
                $result = $location->delete();
                return response()->json(["success" => $result]);
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);    
    }
}
