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

      /**
     *
     * @test
     */
     public function Get_Brand_Fails_If_Not_Authed()
     {
         $response = $this->json('GET','/api/brand/1');
        
         $response->assertJson([
             'message' => "Unauthenticated.",
         ]);
         $response->assertStatus(401);
     }

      /**
     *
     * @test
     */
     public function Post_Brand_Stores_In_DB()
     {
         Airlock::actingAs(
             factory(User::class)->create(),
             ['store']
         );
 
         $brand = factory(brand::class)->create();
        
         $response = $this->json('POST','/api/brands', ['brand_name' => $brand->brand_name,
         'location_id' => $brand->location_id,  'telephone' => $brand->telephone,
         'email' => $brand->email,
         'website' => $brand->website,
        
         ]); 
        
         $response->assertJsonCount(8);
         $response->assertStatus(201);
     }

      /**
     *
     * @test
     */
    public function Missing_Name_Gives_Error()
    {
        Airlock::actingAs(
            factory(User::class)->create(),
            ['store']
        );

        $brand = factory(brand::class)->create();
        
        $response = $this->json('POST','/api/brands', [
        'location_id' => $brand->location_id,  'telephone' => $brand->telephone,
        'email' => $brand->email,
        'website' => $brand->website,
        ]); 

        $response->assertJsonCount(2);
        $response->assertStatus(422);
    }
}
