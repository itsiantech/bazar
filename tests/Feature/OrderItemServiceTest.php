<?php

namespace Tests\Feature;

use App\Models\User;
use App\Packages\Shop\OrderItemManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OrderItemServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {

        Artisan::call('migrate');

        $user = User::firstOrCreate(
            [
                'email' => 'gdnayeem1996@gmail.com',
                'phone' => '01836983974',
            ],
            [
                'name' => 'Jannatul Nayeem',
                'password' => Hash::make("12345678"),
                'is_verified' => 1,
            ]
        );

        Artisan::call('db:seed', ['--class' => 'TestProductSeed']);

        $data = array (
            'cart_json' =>
                array (
                    'order' =>
                        array (
                            'user_id' => 166,
                            'payment_method_id' => 1,
                            'delivery_charge_id' => 1,
                            'total_saved' => 10,
                            'address_id' => 1,
                            'orderItems' =>
                                array (
                                    0 =>
                                        array (
                                            'product_id' => 1,
                                            'name' => 'White Grapes(Net Weight ± 50 gm)',
                                            'quantity' => 1,
                                            'price' => 120,
                                        ),
                                ),
                            'amount' => 115,
                        ),
                ),
        );




//        $response = $this->actingAs($user)->post('/api/orders/initiate_payment', $data);
//
//        $response_data= json_decode($response->getContent());
//
//        $response->assertStatus(200);
//
//        if($response_data->status == 'fail') dd($response_data);




        $operation = 'remove';
        $orderItem  = new OrderItemManager(640);

        $orderItem->SetOperation($operation);
        $orderItem->ApplicableWalletAmount();

    }
}
