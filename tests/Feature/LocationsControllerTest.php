<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Airlock\Airlock;
use App\User;
use App\Location;

class LocationsControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     *
     * @test
     */
    public function Get_Locations_Returns_Locations_Collection()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['index']
        );

        $response = $this->json('GET','/api/locations');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Location_By_ID_Returns_Location()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );
        factory(Location::class)->create();

        $response = $this->json('GET','/api/location/1');
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }

    /**
     *
     * @test
     */
    public function Get_Unknown_Location_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );
        $response = $this->json('GET','/api/location/1');
       
        $response->assertStatus(404);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_All_Gives_Error()
    {
        $response = $this->json('GET','/api/locations');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Unauthorised_Get_Location_Gives_Error()
    {
        $response = $this->json('GET','/api/location/1');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

     /**
     *
     * @test
     */
    public function Delete_Location_Removes_Db_Entry()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        factory(Location::class)->create();

        $response = $this->json('DELETE','/api/location/1');
        $response->assertJson([
            'success' => 1,
        ]);
        $response->assertStatus(200);

    }

     /**
     *
     * @test
     */
    public function Delete_Unknown_Location_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->json('DELETE','/api/location/1');
        $response->assertStatus(404);

    }

    /**
     *
     * @test
     */
    public function Delete_Fails_If_Unauthorised()
    {
        $response = $this->json('DELETE','/api/location/1');
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);

    }

}
