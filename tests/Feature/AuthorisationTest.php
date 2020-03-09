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
     *
     * @test
     */
    public function User_Should_See_Login_Page_When_Not_Logged_In()
    {
        $response = $this->get('/login');
        $response->assertViewIs('auth.login');
        $response->assertStatus(200);
    }
    
    /**
     *
     * @test
     */
    public function User_Should_Be_Redirected_To_Login_When_Not_Authorised()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    /**
     * 
     * @test
     */
    public function Authenticated_Users_Can_See_Dashboard_When_LoggedIn()
    {
        $user = factory(User::class)->create([
        'password' => bcrypt($password = 'test123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     *
     * @test
     */
    public function Incorrect_Credentials_Do_Not_Allow_Login()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('test123'),
        ]);
        
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
        
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertInvalidCredentials(['email' => $user->email,
        'password' => 'invalid-password',] );
        $this->assertGuest();
    }
}
