<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use App\Permission;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Return a collection of users.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Access To All Users")
            {
                return new UserCollection(User::all());
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreUser  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Create New User")
            {
                $user = User::create($request->validated());
                return $user;
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
        if ($permissions) {
            foreach($permissions as $permission) {
                if ($permission->description == "Allow Access To User")
                {
                    return new UserResource(User::where('id',$id)->firstOrFail());
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
    public function update(UpdateUser $request, $id)
    {
        $permissions = User::GetPermissions();
        foreach($permissions as $permission) {
            if ($permission->description == "Allow Update User")
            {
                $user = User::findOrFail($id);
                $user->update($request->validated());
                return $user;
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
            if ($permission->description == "Allow Delete User")
            {
                $user = User::findOrFail($id);
                $result = $user->delete();
                return response()->json(["success" => $result]);
            }
        }
        return response()->json(['error' => 'Not Authorised.'], 401);
    }
}
