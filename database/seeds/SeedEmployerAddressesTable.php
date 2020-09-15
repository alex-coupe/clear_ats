<?php

use Illuminate\Database\Seeder;

class SeedEmployerAddressesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EmployerAddress::class,10)->create();
    }
}
