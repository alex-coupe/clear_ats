<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use App\Recruiter;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecruitersControllerTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     *
     * @test
     */
    public function Get_Recruiters_Returns_Recruiters_Collection()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['index']
        );
        factory(Permission::class)->create([
            'description' => 'Allow Access To All Recruiters',
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
             'active' => true
           ]);
        $response = $this->json('GET','/api/recruiters');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Recruiter_By_ID_Returns_Recruiter()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(['role_id' => 1]),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Recruiter',
            
        ]);

        factory(Role::class)->create();

      
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);
              
        $response = $this->json('GET','/api/recruiter/1');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_Recruiter_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);
        $response = $this->json('GET','/api/recruiter/2');
       
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_Gives_Error()
    {
        $response = $this->json('GET','/api/recruiter/2');
       
        $response->assertJson([
            'error' => "Not Authorised.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Stores_In_DB()
    {
       
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        "last_name" => $recruiter->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'password' => $recruiter->password,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
      
        $response->assertJsonCount(13);
        $response->assertStatus(201);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_First_Name_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', [
        "last_name" => $recruiter->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'password' => $recruiter->password,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Last_Name_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'email' => 'unique@unique.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'password' => $recruiter->password,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Email_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1,
            'active' => true 
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        'email_verified_at' => $recruiter->email_verified_at,
        'password' => $recruiter->password,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

     /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Password_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => $recruiter->email,
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Telephone_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1,
            'active' => true 
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => $recruiter->email,
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_company_address_id_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1,
            'active' => true 
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => $recruiter->email,
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

     /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Role_Id_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => $recruiter->email,
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }



    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Job_Title_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1,
            'active' => true 
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => $recruiter->email,
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Missing_Mobile_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1,
            'active' => true 
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => $recruiter->email,
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_Recruiter_Erroneous_Email_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => 'this_is_not_an_email.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'mobile' => $recruiter->job_title,
        'job_title' => $recruiter->job_title,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }


     /**
     *
     * @test
     */
    public function Post_Recruiter_Duplicate_Email_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Create New Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => 'dupe@email.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'mobile' => $recruiter->job_title,
        'job_title' => $recruiter->job_title,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        'last_name' => $recruiter->last_name,
        "email" => 'dupe@email.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'remember_token' => $recruiter->remember_token,
        'password' => $recruiter->password,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'mobile' => $recruiter->job_title,
        'job_title' => $recruiter->job_title,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }


     /**
     *
     * @test
     */
    public function Unauth_Post_Gives_Errors()
    {
        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        "last_name" => $recruiter->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'password' => $recruiter->password,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);
       
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Put_Recruiter_Updates_DB_Entry()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Update Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $recruiter = factory(Recruiter::class)->create();
        $response = $this->json('POST','/api/recruiters', ["first_name" => $recruiter->first_name,
        "last_name" => $recruiter->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $recruiter->email_verified_at,
        'password' => $recruiter->password,
        'remember_token' => $recruiter->remember_token,
        'telephone' => $recruiter->telephone,
        'company_address_id' => $recruiter->company_address_id,
        'job_title' => $recruiter->job_title,
        'mobile' => $recruiter->mobile,
        'role_id' => $recruiter->role_id,
        'company_id' => $recruiter->company_id
        ]);

        $response = $this->json('PUT','/api/recruiter/1', ["first_name" => 'updated name']);
        
        $response->assertJson([
            'first_name' => 'updated name',
        ]);
        $response->assertStatus(200);
    }
    

     /**
     *
     * @test
     */
    public function Put_Unknown_Recruiter_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Update Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $response = $this->json('PUT','/api/recruiter/2', ["first_name" => 'updated name']);
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Put_Fails_If_Unauthorised()
    {
        $response = $this->json('PUT','/api/recruiter/1', ["first_name" => 'updated name']);
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

    /**
     *
     * @test
     */
    public function Delete_Recruiter_Removes_DB_Entry()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Delete Recruiter',
            
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1,
            'active' => true 
        ]);

        $response = $this->json('DELETE','/api/recruiter/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }
    
    /**
     *
     * @test
     */
    public function Delete_Unknown_Recruiter_Gives_Error()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['*']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Delete Recruiter',
        ]);

        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
        [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
        ]);

        $response = $this->json('DELETE','/api/recruiter/2');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/recruiter/2');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }
}
