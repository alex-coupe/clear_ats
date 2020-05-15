<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use App\Recruiter;
use App\CompanyAddress;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompanyAddressesControllerTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     *
     * @test
     */
    public function Get_Company_Addresses_Returns_Company_Addresses_Collection()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['index']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To All Company Addresses',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('GET','/api/companyaddresses');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_CompanyAddress_By_ID_Returns_CompanyAddress()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Company Address',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(CompanyAddress::class)->create();

        $response = $this->json('GET','/api/companyaddress/1');
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_CompanyAddress_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Company Address',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('GET','/api/companyaddress/1');
       
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_All_Gives_Error()
    {
        $response = $this->json('GET','/api/companyaddresses');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_CompanyAddress_Gives_Error()
    {
        $response = $this->json('GET','/api/companyaddress/1');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

     /**
     *
     * @test
     */
     public function Post_CompanyAddress_Stores_In_DB()
     {
         Airlock::actingAs(
             factory(Recruiter::class)->create(),
             ['store']
         );

         factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);
 
         $companyAddress = factory(CompanyAddress::class)->create();
        
         $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
         'address_one' => $companyAddress->address_one,  'address_two' => $companyAddress->address_two,
         'address_three' => $companyAddress->address_three,
         'city' => $companyAddress->city,
         'state' => $companyAddress->state,
         'post_code' => $companyAddress->post_code,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $companyAddress = factory(CompanyAddress::class)->create();
       
        $response = $this->json('POST','/api/companyaddresses', [
        'address_one' => $companyAddress->address_one,  'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'city' => $companyAddress->city,
        'state' => $companyAddress->state,
        'post_code' => $companyAddress->post_code,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $companyAddress = factory(CompanyAddress::class)->create();
       
        $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
        'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'city' => $companyAddress->city,
        'state' => $companyAddress->state,
        'post_code' => $companyAddress->post_code,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $companyAddress = factory(CompanyAddress::class)->create();
       
        $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
        'address_one' => $companyAddress->address_one,
        'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'state' => $companyAddress->state,
        'post_code' => $companyAddress->post_code,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $companyAddress = factory(CompanyAddress::class)->create();
       
        $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
        'address_one' => $companyAddress->address_one,
        'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'city' => $companyAddress->city,
        'post_code' => $companyAddress->post_code,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $companyAddress = factory(CompanyAddress::class)->create();
       
        $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
        'address_one' => $companyAddress->address_one,
        'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'city' => $companyAddress->city,
        'state' => $companyAddress->state,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $companyAddress = factory(CompanyAddress::class)->create();
       
        $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
        'address_one' => $companyAddress->address_one,
        'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'city' => $companyAddress->city,
        'state' => $companyAddress->state,
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
        $companyAddress = factory(CompanyAddress::class)->create();
        
        $response = $this->json('POST','/api/companyaddresses', ['name' => $companyAddress->name,
        'address_one' => $companyAddress->address_one,  'address_two' => $companyAddress->address_two,
        'address_three' => $companyAddress->address_three,
        'city' => $companyAddress->city,
        'state' => $companyAddress->state,
        'post_code' => $companyAddress->post_code,
        ]);
       
        $response->assertJsonCount(1);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Put_CompanyAddress_Updates_DB_Entry()
    {
        $this->withoutExceptionHandling();
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Edit Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);


        factory(CompanyAddress::class)->create();

        $response = $this->json('PUT','/api/companyaddress/1', ["name" => 'updated name']);
        
        $response->assertJson([
            'name' => 'updated name',
        ]);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
    public function Put_Unknown_CompanyAddress_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        
        factory(Permission::class)->create([
            'description' => 'Allow Edit Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('PUT','/api/companyaddress/1', ["name" => 'updated name']);
        $response->assertStatus(404);
    }

      /**
     *
     * @test
     */
    public function Put_Fails_If_Unauthorised()
    {
        $response = $this->json('PUT','/api/companyaddress/1', ["name" => 'updated name']);
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }


     /**
     *
     * @test
     */
    public function Delete_CompanyAddress_Removes_Db_Entry()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        
        factory(Permission::class)->create([
            'description' => 'Allow Delete Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(CompanyAddress::class)->create();

        $response = $this->json('DELETE','/api/companyaddress/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }

     /**
     *
     * @test
     */
    public function Delete_Unknown_CompanyAddress_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        
        factory(Permission::class)->create([
            'description' => 'Allow Delete Company Address',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('DELETE','/api/companyaddress/1');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/companyaddress/1');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

}
