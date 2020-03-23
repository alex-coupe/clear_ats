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

      /**
     *
     * @test
     */
    public function Get_Brands_Fails_If_Not_Authed()
    {
        $response = $this->json('GET','/api/brands');
       
        $response->assertJson([
            'message' => "Unauthenticated.",
        ]);
        $response->assertStatus(401);
    }

    /**
     *
     * @test
     */
    public function Get_Brand_Returns_Single_Brand()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['show']
        );

        factory(Brand::class)->create();

        $response = $this->json('GET','/api/brand/1');
       
        $response->assertJsonCount(1);
        $response->assertStatus(200);
    }
}
