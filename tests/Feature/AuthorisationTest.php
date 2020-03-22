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
        $response = $this->get('/');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
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

     /**
     * A candidate should be able to tick remember me and have a session cookie saved
     * @test
     */
    public function Selecting_Remember_Me_Correctly_Creates_Cookie()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        $response->assertRedirect('/dashboard');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }

    /**
     *
     * @test
     */
    public function Forgot_My_Password_Should_Send_Email_Link()
    {
        Notification::fake();
      
        $user = factory(User::class)->create();
      
        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);

        $token = DB::table('password_resets')->first();
        $this->assertNotNull($token);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    /**
     * 
     * @test
     */
    public function Logout_Should_Delete_Session()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        Auth::logout();

        $this->assertGuest();

    }

    /**
     * 
     * @test
     */
    public function Login_Snapshot_Test()
    {
        $view = 'resources\views\auth\login.blade.php';

        $this->assertMatchesFileSnapshot($view);
    }

     /**
     *
     * @test
     */
    public function Redirect_To_Dashboard_When_Loggedin()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->get('/login');
        $response->assertRedirect('/dashboard');
        $response->assertStatus(302);
    }
}
