<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Http\Requests\StoreBrand;
use App\Http\Requests\UpdateBrand;
use App\Brand;
use App\User;

class BrandsController extends Controller
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
            if ($permission->description == "Allow Access To All Brands")
            {
                return new BrandCollection(Brand::all());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreBrand  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrand $request)
    {
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create Brand")
            {
                $brand = Brand::create($request->validated());
                return $brand;
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
            if ($permission->description == "Allow Access To Specific Brand")
            {
                return new BrandResource(Brand::where('id',$id)->firstOrFail());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\UpdateBrand  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrand $request, $id)
    {
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Edit Brand")
            {
                $brand = Brand::findOrFail($id);
                $brand->update($request->validated());
                return $brand;
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
            if ($permission->description == "Allow Delete Brand")
            {
                $brand = Brand::findOrFail($id);
                $result = $brand->delete();
                return response()->json(["success" => $result]);
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401); 
    }
}
