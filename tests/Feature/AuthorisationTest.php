<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use App\User;

class AuthorisationTest extends TestCase
{
    use RefreshDatabase;
    use MatchesSnapshots;
    
    /**
    * @test
    */
    public function Candidate_Route_Should_Return_Login_Page_When_Not_LoggedIn()
    {
        $response = $this->get('/candidates');
        $response->assertViewIs('auth.login');
        $response->assertStatus(200);
    }

    /**
    * @test
    */
    public function Recruiter_Route_Should_Return_Login_Page_When_Not_LoggedIn()
    {
        $response = $this->get('/recruiters');
        $response->assertViewIs('auth.login');
        $response->assertStatus(200);
    }
}
