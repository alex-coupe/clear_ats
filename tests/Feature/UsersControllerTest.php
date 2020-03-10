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
}
