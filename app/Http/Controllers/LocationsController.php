<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Location;
use App\Http\Requests\StoreLocation;
use App\Http\Requests\UpdateLocation;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new LocationCollection(Location::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreLocation  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        $location = Location::create($request->validated());
        return $location;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new LocationResource(Location::where('id',$id)->firstOrFail());
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
        $location = Location::findOrFail($id);
        $location->update($request->validated());
        return $location;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $result = $location->delete();
        return response()->json(["success" => $result]);
    }
}
