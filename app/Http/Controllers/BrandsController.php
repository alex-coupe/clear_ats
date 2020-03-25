<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\Http\Requests\StoreBrand;
use App\Http\Requests\UpdateBrand;
use App\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BrandCollection(Brand::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreBrand  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrand $request)
    {
        $brand = Brand::create($request->validated());
        return $brand;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BrandResource(Brand::where('id',$id)->firstOrFail());
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
        $brand = Brand::findOrFail($id);
        $brand->update($request->validated());
        return $brand;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $result = $brand->delete();
        return response()->json(["success" => $result]);
    }
}
