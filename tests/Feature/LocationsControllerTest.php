<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use App\User;
use App\Location;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationsControllerTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     *
     * @test
     */
    public function Get_Locations_Returns_Locations_Collection()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['index']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To All Locations',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('GET','/api/locations');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Location_By_ID_Returns_Location()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Location::class)->create();

        $response = $this->json('GET','/api/location/1');
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_Location_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('GET','/api/location/1');
       
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_All_Gives_Error()
    {
        $response = $this->json('GET','/api/locations');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_Location_Gives_Error()
    {
        $response = $this->json('GET','/api/location/1');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

     /**
     *
     * @test
     */
     public function Post_Location_Stores_In_DB()
     {
         Airlock::actingAs(
             factory(User::class)->create(),
             ['store']
         );

         factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);
 
         $location = factory(Location::class)->create();
        
         $response = $this->json('POST','/api/locations', ['name' => $location->name,
         'address_one' => $location->address_one,  'address_two' => $location->address_two,
         'address_three' => $location->address_three,
         'city' => $location->city,
         'state' => $location->state,
         'post_code' => $location->post_code,
         ]);
        
         $response->assertJsonCount(10);
         $response->assertStatus(201);
     }

      /**
     *
     * @test
     */
    public function Missing_Name_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $location = factory(Location::class)->create();
       
        $response = $this->json('POST','/api/locations', [
        'address_one' => $location->address_one,  'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'city' => $location->city,
        'state' => $location->state,
        'post_code' => $location->post_code,
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

      /**
     *
     * @test
     */
    public function Missing_Address_Line_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $location = factory(Location::class)->create();
       
        $response = $this->json('POST','/api/locations', ['name' => $location->name,
        'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'city' => $location->city,
        'state' => $location->state,
        'post_code' => $location->post_code,
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

     /**
     *
     * @test
     */
    public function Missing_City_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $location = factory(Location::class)->create();
       
        $response = $this->json('POST','/api/locations', ['name' => $location->name,
        'address_one' => $location->address_one,
        'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'state' => $location->state,
        'post_code' => $location->post_code,
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Missing_State_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $location = factory(Location::class)->create();
       
        $response = $this->json('POST','/api/locations', ['name' => $location->name,
        'address_one' => $location->address_one,
        'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'city' => $location->city,
        'post_code' => $location->post_code,
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Missing_Post_Code_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $location = factory(Location::class)->create();
       
        $response = $this->json('POST','/api/locations', ['name' => $location->name,
        'address_one' => $location->address_one,
        'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'city' => $location->city,
        'state' => $location->state,
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Erroneous_Post_Code_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $location = factory(Location::class)->create();
       
        $response = $this->json('POST','/api/locations', ['name' => $location->name,
        'address_one' => $location->address_one,
        'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'city' => $location->city,
        'state' => $location->state,
        'post_code' => 'CTAA1AA'
        ]);

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }


      /**
     *
     * @test
     */
    public function Unauth_Post_Gives_Errors()
    {
        $location = factory(Location::class)->create();
        
        $response = $this->json('POST','/api/locations', ['name' => $location->name,
        'address_one' => $location->address_one,  'address_two' => $location->address_two,
        'address_three' => $location->address_three,
        'city' => $location->city,
        'state' => $location->state,
        'post_code' => $location->post_code,
        ]);
       
        $response->assertJsonCount(1);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Put_Location_Updates_DB_Entry()
    {
        $this->withoutExceptionHandling();
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Edit Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);


        factory(Location::class)->create();

        $response = $this->json('PUT','/api/location/1', ["name" => 'updated name']);
        
        $response->assertJson([
            'name' => 'updated name',
        ]);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
    public function Put_Unknown_Location_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        
        factory(Permission::class)->create([
            'description' => 'Allow Edit Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('PUT','/api/location/1', ["name" => 'updated name']);
        $response->assertStatus(404);
    }

      /**
     *
     * @test
     */
    public function Put_Fails_If_Unauthorised()
    {
        $response = $this->json('PUT','/api/location/1', ["name" => 'updated name']);
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }


     /**
     *
     * @test
     */
    public function Delete_Location_Removes_Db_Entry()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        
        factory(Permission::class)->create([
            'description' => 'Allow Delete Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Location::class)->create();

        $response = $this->json('DELETE','/api/location/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }

     /**
     *
     * @test
     */
    public function Delete_Unknown_Location_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        
        factory(Permission::class)->create([
            'description' => 'Allow Delete Location',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('DELETE','/api/location/1');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/location/1');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

}
