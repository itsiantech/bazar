<?php

use Illuminate\Database\Seeder;

class TopTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\TopType::class,5)->create();

    }
}
