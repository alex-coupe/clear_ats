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

}
