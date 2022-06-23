<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Validation\Rule;
use Validator;
use App\Models\Product;

class ProductTest extends TestCase
{
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
     *
     * @return void
     */
    public function test_create_product()
    {
        $response = $this->post('api/product', [
            'name' => 'Celestine Walker',
            'description' => 'New product in stock',
            'quantity' => '80',
            'price' => '200',
            'itemNUmber' => 'BVIL8908SS'
        ]);
        
        $response->assertStatus(302);
    }

    public function test_retrive_product()
    {
        $response = $this->get('api/product');
        $response->assertStatus(200);
    }

    // public function test_delete_product()
    // {
    //     $client = Product::findOrFail(1);
    //     $response = $this->delete('api/product/'.$client);
    //     $response->assertStatus(200);
    // }
}
