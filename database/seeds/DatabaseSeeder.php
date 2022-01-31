<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        //    RoleSeeder::class,
       //     PermissionSeeder::class,
            UserSeeder::class,
//            CategoriesSeeder::class,
//            ProductSeeder::class,
//            ProductReviewSeeder::class,
        //TopTypeSeeder::class,
          //  TopProductSeeder::class
        ]);
    }
}
