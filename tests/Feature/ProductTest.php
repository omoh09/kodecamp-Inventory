<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     *Testing for validation
     * @return void
     */
    public function test_validitionFailNameRequired()
    {
        $response = $this->json('POST', 'api/product', [
            'price' => 500,
            'quantity' => 1,
            'ItemNumber' => 'KODE2022CAMP',
            'description' => 'A new product',
            ]);

        $response->assertStatus(422);
    }

    public function test_validitionFailPriceRequired()
    {
        $response = $this->json('POST', 'api/product', [
                'name' => 'PHP full course',
                'quantity' => 1,
                'ItemNumber' => 'KODE2022CAMP',
                'description' => 'A new product',
            ]);

        $response->assertStatus(422);
    }

    public function test_validitionFailQuantityRequired()
    {
        $response = $this->json('POST', 'api/product', [
                'name' => 'PHP full course',
                'price' => 200,
                'ItemNumber' => 'KODE2022CAMP',
                'description' => 'A new product',
            ]);

        $response->assertStatus(422);
    }

    public function test_validitionFailDescriptionRequired()
    {
        $response = $this->json('POST', 'api/product', [
                'name' => 'PHP full course',
                'price' => 200,
                'quantity' => 1,
                'ItemNumber' => 'KODE2022CAMP',
            ]);

        $response->assertStatus(422);
    }

    public function test_validitionFailItemnumberRequired()
    {
        $response = $this->json('POST', 'api/product', [
                'name' => 'PHP full course',
                'price' => 200,
                'quantity' => 1,
                'description' => 'A new product',
            ]);

        $response->assertStatus(422);
    }

    public function test_validitionFailWherePriceNotAnInteger()
    {
        $response = $this->json('POST', 'api/product', [
                'name' => 'PHP full course',
                'price' => '200',
                'quantity' => 1,
                'description' => 'A new product',
                'ItemNumber' => 'KODE2022CAMP',
            ]);

        $response->assertStatus(422);
    }

    public function test_validitionFailWhereQuantityNotAnInteger()
    {
        $response = $this->json('POST', 'api/product', [
                'name' => 'PHP full course',
                'price' => 200,
                'quantity' => '1',
                'description' => 'A new product',
                'ItemNumber' => 'KODE2022CAMP',
            ]);

        $response->assertStatus(422);
    }
    // Testing for validation ends\\

    //test POST route
    public function test_post_route_to_create_a_product()
    {
        $response = $this->json('POST', 'api/product', [
            'name' => $this->faker->firstName(),
            'description' => 'New product in stock',
            'quantity' => 80,
            'price' => 200,
            'itemNUmber' => 'BVIL8908SS'
        ]);
        
        $response->assertOk();
    }

    //test GET route
    public function test_get_route_to_retrive_all_product()
    {
        $response = $this->get('api/product');

        $response->assertOk();
    }

    //test GET product by ID route
    public function test_get_product_by_id_route()
    {
        $client = Product::factory()->create()->id;
        
        $response = $this->json('GET', 'api/product/'.$client);
        
        $response->assertOk();
    }

    //test PUT route
    public function test_put_route_to_update_a_product()
    {
        $client = Product::factory()->create()->id;
        
        $response = $this->json('PUT', 'api/product/'.$client, [
        'name' => 'PHILO',
        'description' => 'New product in stock',
        'quantity' => 80,
        'price' => 200,
        'ItemNUmber' => '12345philo'
        ]);
        
        $response->assertOk();
    }

    //test DELETE route
    public function test_delete_route_to_delete_a_product()
    {
        $client = Product::factory()->create()->id;
        
        $response = $this->json('DELETE', 'api/product/'.$client);
        
        $response->assertOk();
    }
}
