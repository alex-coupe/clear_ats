<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Company;
use Laravel\Airlock\Airlock;
use App\Recruiter;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompaniesControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @test
     */
    public function Get_Companies_Returns_Companies_Collection()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['index']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To All Companies',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('GET','/api/companies');
 
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
    public function Get_Companies_Fails_If_Not_Authed()
    {
        $response = $this->json('GET','/api/companies');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Get_Company_Returns_Single_Company()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Company::class)->create();

        $response = $this->json('GET','/api/company/1');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
     public function Get_Company_Fails_If_Not_Authed()
     {
         $response = $this->json('GET','/api/company/1');
        
         $response->assertJson([
             'message' => "Unauthenticated.",
         ]);
         $response->assertStatus(401);
     }

     /**
     *
     * @test
     */
     public function Post_Company_Stores_In_DB()
     {
         Airlock::actingAs(
             factory(Recruiter::class)->create(),
             ['store']
         );

         factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);
 
         $company = factory(Company::class)->create();
        
         $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
         'location_id' => $company->location_id,  'telephone' => $company->telephone,
         'email' => $company->email,
         'website' => $company->website,
        
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
        
        $response = $this->json('POST','/api/companies', [
        'location_id' => $company->location_id,  'telephone' => $company->telephone,
        'email' => $company->email,
        'website' => $company->website,
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
       
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
         'telephone' => $company->telephone,
        'email' => $company->email,
        'website' => $company->website,
       
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
       
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
        'location_id' => $company->location_id,  
        'email' => $company->email,
        'website' => $company->website,
       
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
       
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
        'location_id' => $company->location_id,  
        'telephone' => $company->telephone,
        'website' => $company->website,
       
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
       
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
        'location_id' => $company->location_id,  
        'email' => $company->email,
        'telephone' => $company->telephone,
       
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
        
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
        'location_id' => $company->location_id,  'telephone' => '01125',
        'email' => $company->email,
        'website' => $company->website,
       
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
        
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
        'location_id' => $company->location_id,  'telephone' => $company->telephone,
        'email' => 'bla.g',
        'website' => $company->website,
       
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
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $company = factory(Company::class)->create();
        
        $response = $this->json('POST','/api/companies', ['company_name' => $company->company_name,
        'location_id' => $company->location_id,  'telephone' => $company->telephone,
        'email' => $company->email,
        'website' => 'not today',
       
        ]); 

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Put_Company_Updates_DB_Entry()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Edit Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Company::class)->create();

        $response = $this->json('PUT','/api/company/1', ["Company_name" => 'updated name']);
        
        $response->assertJson([
            'Company_name' => 'updated name',
        ]);
        $response->assertStatus(200);
    }

     /**
     *
     * @test
     */
    public function Put_Unknown_Company_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Edit Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);
    
        $response = $this->json('PUT','/api/company/1', ["Company_name" => 'updated name']);
        $response->assertStatus(404);
    }

      /**
     *
     * @test
     */
    public function Put_Company_Fails_If_Unauthorised()
    {
        $response = $this->json('PUT','/api/company/1', ["Company_name" => 'updated name']);
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }



     /**
     *
     * @test
     */
    public function Delete_Company_Removes_Db_Entry()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Delete Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        factory(Company::class)->create();

        $response = $this->json('DELETE','/api/company/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }

     /**
     *
     * @test
     */
    public function Delete_Unknown_Company_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Delete Company',
            'active' => true
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
           ]);

        $response = $this->json('DELETE','/api/company/1');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/company/1');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

}
