<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use App\Recruiter;
use App\Permission;
use App\Role;
use App\Candidate;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CandidatesControllerTest extends TestCase
{
    use DatabaseMigrations;
    

    
    /**
     *
     * @test
     */
    public function Get_Candidates_Returns_Candidates_Collection()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['index']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To All Candidates',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
             'active' => true
           ]);

        factory(Candidate::class, 10)->create();

        $response = $this->json('GET','/api/candidates');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

     /**
     *
     * @test
     */
    public function Get_Candidates_Fails_If_Not_Authed()
    {
        $response = $this->json('GET','/api/candidates');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Get_Candidate_Returns_Single_Candidate()
    {
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['show']
        );

        factory(Permission::class)->create([
            'description' => 'Allow Access To Specific Candidate',
            
        ]);
        factory(Role::class)->create();
        DB::table('role_permissions')->insert(
            [
             'permission_id' => 1, 
             'role_id' => 1, 
             'active' => true
           ]);

        factory(Candidate::class)->create();

        $response = $this->json('GET','/api/candidate/1');
        
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

      /**
     *
     * @test
     */
    public function Get_Candidate_Fails_If_Not_Authed()
    {
        $response = $this->json('GET','/api/candidate/1');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

     /**
     *
     * @test
     */
    public function Post_Candidate_Stores_In_DB()
    {
        $this->withoutExceptionHandling();
        Airlock::actingAs(
            factory(Recruiter::class)->create(),
            ['store']
        );

        factory(Permission::class)->create([
           'description' => 'Allow Create Candidates',
           
       ]);
       factory(Role::class)->create();
       DB::table('role_permissions')->insert(
           [
            'permission_id' => 1, 
            'role_id' => 1, 
            'active' => true
          ]);

        $candidate = factory(Candidate::class)->create();
       
        Storage::fake('local');
        $response = $this->json('POST','/api/candidates', ['first_name' => $candidate->first_name,
        'last_name' => $candidate->last_name,   'email' => $candidate->email, 'recruiter_id' => $candidate->recruiter_id,
        'current_salary' => $candidate->current_salary, 'expected_salary' => $candidate->expected_salary, 'current_role' => $candidate->current_role,
        'current_sector' => $candidate->current_sector,   
        'cv' => UploadedFile::fake()->create($candidate->first_name.$candidate->last_name.'cv.doc',3567,'.doc'),
        'cover' => UploadedFile::fake()->create($candidate->first_name.$candidate->last_name.'cover_letter.doc',1200,'.doc')
           ]);
        Storage::disk('local')->assertExists('files/'.$candidate->first_name.$candidate->last_name.'cv.doc', 
        Storage::disk('local')->assertExists('files/'.$candidate->first_name.$candidate->last_name.'cover_letter.doc'),
        );
        
        $response->assertJsonCount(12);
        $response->assertStatus(201);
    }


}
