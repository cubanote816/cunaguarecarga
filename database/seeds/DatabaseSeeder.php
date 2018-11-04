<?php

use App\Entry;
use Illuminate\Database\Seeder;
use Laravel\Passport\Bridge\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->states('admin')
            ->create(['name' => 'Admin', 'email' => 'admin@gmail.com']);

        factory(App\User::class)->states('manager')
            ->create(['name' => 'Manager', 'email' => 'manager@gmail.com']);

        factory(App\User::class)->states('reseller')
            ->create(['name' => 'Reseller', 'email' => 'reseller@gmail.com']);

        factory(App\User::class)->states('seller')
            ->create(['name' => 'Seller', 'email' => 'seller@gmail.com']);

    }
}
