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
use App\Recruiter;

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
        $this->withSession(['_token'=>'test']);
       $recruiter = factory(Recruiter::class)->create([
        'password' => bcrypt($password = 'test123'),
        ]);

        $response = $this->post('/login', [
            'email' =>$recruiter->email,
            'password' => $password,
            '_token' => 'test'
        ]);

       

        $this->assertAuthenticatedAs($recruiter);
    }

    /**
     *
     * @test
     */
    public function Incorrect_Credentials_Do_Not_Allow_Login()
    {
       $recruiter = factory(Recruiter::class)->create([
            'password' => bcrypt('test123'),
        ]);
        
        $response = $this->from('/login')->post('/login', [
            'email' =>$recruiter->email,
            'password' => 'invalid-password',
        ]);
        
        $this->assertInvalidCredentials(['email' =>$recruiter->email,
        'password' => 'invalid-password',] );
        $this->assertGuest();
    }

     /**
     * A candidate should be able to tick remember me and have a session cookie saved
     * @test
     */
    public function Selecting_Remember_Me_Correctly_Creates_Cookie()
    {
        $this->withSession(['_token'=>'test']);
       $recruiter = factory(Recruiter::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' =>$recruiter->email,
            'password' => $password,
            'remember' => 'on',
            '_token' => 'test'
        ]);
       
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
           $recruiter->id,
           $recruiter->getRememberToken(),
           $recruiter->password,
        ]));

       
        $this->assertAuthenticatedAs($recruiter);
    }

    /**
     *
     * @test
     */
    public function Forgot_My_Password_Should_Send_Email_Link()
    {
        $this->withSession(['_token'=>'test']);
        Notification::fake();
      
       $recruiter = factory(Recruiter::class)->create();
      
        $response = $this->post('/password/email', [
            'email' =>$recruiter->email,
            '_token' => 'test'
        ]);

        $token = DB::table('password_resets')->first();
        $this->assertNotNull($token);

        Notification::assertSentTo($recruiter, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    /**
     * 
     * @test
     */
    public function Logout_Should_Delete_Session()
    {
        $this->withSession(['_token'=>'test']);
       $recruiter = factory(Recruiter::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' =>$recruiter->email,
            'password' => $password,
            'remember' => 'on',
            '_token' => 'test'
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
