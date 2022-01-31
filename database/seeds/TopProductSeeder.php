<?php

use Illuminate\Database\Seeder;

class TopProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\TopProduct::class,100)->create();

    }
}
