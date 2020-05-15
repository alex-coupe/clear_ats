<?php

use Illuminate\Database\Seeder;

class CompanyAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\CompanyAddress::class, 5)->create();
    }
}
