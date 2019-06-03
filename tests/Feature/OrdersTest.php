<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrdersTest extends TestCase
{
    /**
     * A basic test create new order.
     *
     * @return void
     */
    public function testSuccessCreateOrder()
    {
        $response = $this->json('POST', '/api/create-order', ['products' => '{"Яблоко": 3,"Апельсин": 5}', 'address' => 'Test address', 'time_delivery' => "2019-09-12 06:00"]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'Order added',
            ]);
    }

    /**
     * A basic test fail create new order with error in date_format.
     *
     * @return void
     */
    public function testRequestTimeFormatFailCreateOrder()
    {
        $response = $this->json('POST', '/api/create-order', ['products' => '{"Яблоко": 3,"Апельсин": 5}', 'address' => 'Test address', 'time_delivery' => "2019-09-12 06"]);
        $response
            ->assertStatus(400);
    }

    /**
     * A basic test fail create new order with error in products json.
     *
     * @return void
     */
    public function testRequestProductJsonFailCreateOrder()
    {
        $response = $this->json('POST', '/api/create-order', ['products' => '[1, 2]', 'address' => 'Test address', 'time_delivery' => "2019-09-12 06:00"]);
        $response
            ->assertStatus(400);
    }

    /**
     * A basic test change status order.
     *
     * @return void
     */
    public function testSuccessChangeStatusOrder()
    {
        $response = $this->json('POST', '/api/change-status', ['id' => 1, 'status_id' => 2]);
        $response
            ->assertStatus(200);
    }

    /**
     * A basic test change status order with errors in order id.
     *
     * @return void
     */
    public function testFailChangeStatusOrder()
    {
        $response = $this->json('POST', '/api/change-status', ['id' => 0, 'status_id' => 2]);
        $response
            ->assertStatus(400);
    }

}
