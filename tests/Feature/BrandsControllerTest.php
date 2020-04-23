<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Brand;
use Laravel\Airlock\Airlock;
use App\User;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BrandsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    public function Get_Brands_Returns_Brands_Collection()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['index']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To All Brands',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('GET','/api/brands');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
    public function Get_Brands_Fails_If_Not_Authed()
    {
        $response = $this->json('GET','/api/brands');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Get_Brand_Returns_Single_Brand()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Brand::class)->create();

        $response = $this->json('GET','/api/brand/1');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
     public function Get_Brand_Fails_If_Not_Authed()
     {
         $response = $this->json('GET','/api/brand/1');
        
         $response->assertJson([
             'message' => "Unauthenticated.",
         ]);
         $response->assertStatus(401);
     }

     /**
     *
     * @test
     */
     public function Post_Brand_Stores_In_DB()
     {
         Airlock::actingAs(
             factory(User::class)->create(),
             ['store']
         );

         factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);
 
         $brand = factory(brand::class)->create();
        
         $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
         'location_id' => $brand->location_id,  'telephone' => $brand->telephone,
         'email' => $brand->email,
         'website' => $brand->website,
        
         ]); 
        
         $response->assertJsonCount(8);
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
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
        
        $response = $this->json('POST','/api/brands', [
        'location_id' => $brand->location_id,  'telephone' => $brand->telephone,
        'email' => $brand->email,
        'website' => $brand->website,
        ]); 

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

     /**
     *
     * @test
     */
    public function Missing_Location_Id_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
       
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
         'telephone' => $brand->telephone,
        'email' => $brand->email,
        'website' => $brand->website,
       
        ]); 
       
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Missing_Telephone_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
       
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
        'location_id' => $brand->location_id,  
        'email' => $brand->email,
        'website' => $brand->website,
       
        ]); 
       
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Missing_Email_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
       
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
        'location_id' => $brand->location_id,  
        'telephone' => $brand->telephone,
        'website' => $brand->website,
       
        ]); 
       
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Missing_Url_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
       
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
        'location_id' => $brand->location_id,  
        'email' => $brand->email,
        'telephone' => $brand->telephone,
       
        ]); 
       
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Erroneous_Telephone_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
        
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
        'location_id' => $brand->location_id,  'telephone' => '01125',
        'email' => $brand->email,
        'website' => $brand->website,
       
        ]); 

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Erroneous_Email_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
        
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
        'location_id' => $brand->location_id,  'telephone' => $brand->telephone,
        'email' => 'bla.g',
        'website' => $brand->website,
       
        ]); 

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

     /**
     *
     * @test
     */
    public function Erroneous_Url_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $brand = factory(brand::class)->create();
        
        $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
        'location_id' => $brand->location_id,  'telephone' => $brand->telephone,
        'email' => $brand->email,
        'website' => 'not today',
       
        ]); 

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Put_Brand_Updates_DB_Entry()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Edit Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Brand::class)->create();

        $response = $this->json('PUT','/api/brand/1', ["brand_name" => 'updated name']);
        
        $response->assertJson([
            'brand_name' => 'updated name',
        ]);
        $response->assertStatus(200);
    }

     /**
     *
     * @test
     */
    public function Put_Unknown_Brand_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Edit Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);
    
        $response = $this->json('PUT','/api/brand/1', ["brand_name" => 'updated name']);
        $response->assertStatus(404);
    }

      /**
     *
     * @test
     */
    public function Put_Brand_Fails_If_Unauthorised()
    {
        $response = $this->json('PUT','/api/brand/1', ["brand_name" => 'updated name']);
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }



     /**
     *
     * @test
     */
    public function Delete_Brand_Removes_Db_Entry()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Delete Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Brand::class)->create();

        $response = $this->json('DELETE','/api/brand/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }

     /**
     *
     * @test
     */
    public function Delete_Unknown_Brand_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Delete Brand',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('DELETE','/api/brand/1');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/brand/1');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

}
