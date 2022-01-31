<?php

use App\Models\Category;
use App\Models\DeliveryCharge;
use App\Models\Product;
use Illuminate\Database\Seeder;

class TestProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->categorySeed();
        $this->productSeed();
        $this->deliveryChargeSeed();
        $this->couponSeed();
        $this->paymentMethod();
        $this->address();


    }

    private function address()
    {
        \App\Models\Address::firstOrCreate(['id' => 1], [
            'user_id' => '1',
            'address' => 'test',
            'is_active' => '1',
            'receiver_phone' => '01836983974',
        ]);
    }

    private function paymentMethod()
    {
        \App\Models\PaymentMethod::firstOrCreate(['id' => 1], [
            'name' => 'Cash on deivery',
            'short_code' => 'cod',
        ]);
    }

    private function couponSeed()
    {
        DeliveryCharge::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'test',
                'code' => 'test',
                'validity' => '2021-04-09 00:00:00',
                'amount' => '20',
                'max_use' => '2000',
                'is_percent' => '1',
                'is_cash_back' => '0',
                'is_free_delivery' => '1',
            ]
        );
    }

    private function deliveryChargeSeed()
    {
        DeliveryCharge::firstOrCreate(
            ['id' => 1],
            ['charge_amount' => '50', 'minimum_amount' => 1, 'maximum_amount' => 999],
        );
        DeliveryCharge::firstOrCreate(
            ['id' => 2],
            ['charge_amount' => '40', 'minimum_amount' => 1000, 'maximum_amount' => 2999],
        );
        DeliveryCharge::firstOrCreate(
            ['id' => 3],
            ['charge_amount' => '0', 'minimum_amount' => 5000, 'maximum_amount' => 10000],
        );
        DeliveryCharge::firstOrCreate(
            ['id' => 3],
            ['charge_amount' => '30', 'minimum_amount' => 3000, 'maximum_amount' => 4999],
        );
    }


    private function categorySeed()
    {
        Category::firstOrCreate(
            [
                'id' => 1
            ], [
            'name_en' => 'test',
            'slug' => 'test',
        ]);
    }


    private function productSeed()
    {

        Product::firstOrCreate(
            [
                'id' => 1
            ], [
            'category_id' => 1,
            'price_en' => '175',
            'name_en' => 'Malta (Net Weight ± 50 gm)',
            'quantity' => '1',
            'unit' => 'kg',
            'discount' => '20',
            'slug' => 'Malta-Net-Weight-50-gm-',
            'is_active' => '1',
        ]);


        Product::firstOrCreate(
            [
                'id' => 2
            ], [
            'category_id' => 1,
            'price_en' => '218',
            'name_en' => 'Fuji Apple((Net Weight ± 50 gm)',
            'slug' => 'Fuji Apple((Net Weight ± 50 gm)',
            'quantity' => '1',
            'unit' => 'kg',
            'discount' => '20',
            'is_active' => '1',
        ]);


        Product::firstOrCreate(
            [
                'id' => 3
            ], [
            'category_id' => 1,
            'price_en' => '218',
            'name_en' => 'Green Apple((Net Weight ± 50 gm)',
            'slug' => 'Green Apple((Net Weight ± 50 gm)',
            'quantity' => '1',
            'unit' => 'kg',
            'discount' => null,
            'is_active' => '1',
        ]);


        Product::firstOrCreate(
            [
                'id' => 4
            ], [
            'category_id' => 1,
            'price_en' => '218',
            'name_en' => 'Gala Apple((Net Weight ± 50 gm)',
            'slug' => 'Gala Apple((Net Weight ± 50 gm)',
            'quantity' => '1',
            'unit' => 'kg',
            'discount' => null,
            'is_active' => '1',
        ]);


        Product::firstOrCreate(
            [
                'id' => 5
            ], [
            'category_id' => 1,
            'price_en' => '218',
            'name_en' => 'Pears (Nashpati) (Net Weight ± 50 gm)',
            'slug' => 'Pears (Nashpati) (Net Weight ± 50 gm)',
            'quantity' => '1',
            'unit' => 'kg',
            'discount' => null,
            'is_active' => '1',
        ]);


        Product::firstOrCreate(
            [
                'id' => 6
            ], [
            'category_id' => 1,
            'price_en' => '218',
            'name_en' => 'Red Grapes(Net Weight ± 50 gm)',
            'slug' => 'Red Grapes(Net Weight ± 50 gm)',
            'quantity' => '1',
            'unit' => 'kg',
            'discount' => '20',
            'is_active' => '1',
        ]);

    }
}
