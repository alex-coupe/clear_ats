<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Brand;
use Laravel\Airlock\Airlock;
use App\User;

class BrandsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    public function Get_Brands_Returns_Brands_Collection()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['index']
        );

        $response = $this->json('GET','/api/brands');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }
}
