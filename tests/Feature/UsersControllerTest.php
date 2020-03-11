<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use App\User;

class UsersTestController extends TestCase
{
    use RefreshDatabase;
    
    /**
     *
     * @test
     */
    public function Get_Users_Returns_Users_Collection()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['index']
        );
        $response = $this->json('GET','/api/users');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_User_By_ID_Returns_User()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );
        $response = $this->json('GET','/api/user/1');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_User_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );
        $response = $this->json('GET','/api/user/2');
       
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_Gives_Error()
    {
        $response = $this->json('GET','/api/user/2');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Post_User_Stores_In_DB()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        $user = factory(User::class)->create();
        $response = $this->json('POST','/api/users', ["first_name" => $user->first_name,
        "last_name" => $user->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $user->email_verified_at,
        'password' => $user->password,
        'remember_token' => $user->remember_token,
        'telephone' => $user->telephone,
        'location_id' => $user->location_id,
        'job_title' => $user->job_title,
        'mobile' => $user->mobile,
        'dob' => $user->dob
        ]);
       
        $response->assertJsonCount(12);
        $response->assertStatus(201);
    }

    /**
     *
     * @test
     */
    public function Post_User_Missing_First_Name_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        $user = factory(User::class)->create();
        $response = $this->json('POST','/api/users', [
        "last_name" => $user->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $user->email_verified_at,
        'password' => $user->password,
        'remember_token' => $user->remember_token,
        'telephone' => $user->telephone,
        'location_id' => $user->location_id,
        'job_title' => $user->job_title,
        'mobile' => $user->mobile,
        'dob' => $user->dob
        ]);
        
        //Json contains message and errors
        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }

    /**
     *
     * @test
     */
    public function Post_User_Missing_Last_Name_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        $user = factory(User::class)->create();
        $response = $this->json('POST','/api/users', ["first_name" => $user->first_name,
        'email' => 'unique@unique.com',
        'email_verified_at' => $user->email_verified_at,
        'password' => $user->password,
        'remember_token' => $user->remember_token,
        'telephone' => $user->telephone,
        'location_id' => $user->location_id,
        'job_title' => $user->job_title,
        'mobile' => $user->mobile,
        'dob' => $user->dob
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
        $user = factory(User::class)->create();
        $response = $this->json('POST','/api/users', ["first_name" => $user->first_name,
        "last_name" => $user->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $user->email_verified_at,
        'password' => $user->password,
        'remember_token' => $user->remember_token,
        'telephone' => $user->telephone,
        'location_id' => $user->location_id,
        'job_title' => $user->job_title,
        'mobile' => $user->mobile,
        'dob' => $user->dob
        ]);
       
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Put_User_Updates_DB_Entry()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $user = factory(User::class)->create();
        $response = $this->json('POST','/api/users', ["first_name" => $user->first_name,
        "last_name" => $user->last_name,  'email' => 'unique@unique.com',
        'email_verified_at' => $user->email_verified_at,
        'password' => $user->password,
        'remember_token' => $user->remember_token,
        'telephone' => $user->telephone,
        'location_id' => $user->location_id,
        'job_title' => $user->job_title,
        'mobile' => $user->mobile,
        'dob' => $user->dob
        ]);

        $response = $this->json('PUT','/api/user/1', ["first_name" => 'updated name']);
        
        $response->assertJson([
            'first_name' => 'updated name',
        ]);
        $response->assertStatus(200);
    }
    

     /**
     *
     * @test
     */
    public function Put_Unknown_User_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->json('PUT','/api/user/2', ["first_name" => 'updated name']);
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Put_Fails_If_Unauthorised()
    {
        $response = $this->json('PUT','/api/user/1', ["first_name" => 'updated name']);
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

    /**
     *
     * @test
     */
    public function Delete_User_Removes_DB_Entry()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->json('DELETE','/api/user/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }
    
    /**
     *
     * @test
     */
    public function Delete_Unknown_User_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->json('DELETE','/api/user/2');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/user/2');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }
}
