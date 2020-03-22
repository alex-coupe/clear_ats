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
    public function Login_Allows_Request_With_Correct_Credentials()
    {
        $user = factory(User::class)->create([
        'password' => bcrypt($password = 'test123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

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
        $view = 'resources\views\dashboard.blade.php';

        $this->assertMatchesFileSnapshot($view);
    }

}
