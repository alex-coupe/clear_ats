<?php

use Illuminate\Database\Seeder;

class EmployerContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EmployerContact::class, 10)->create();
    }
}
