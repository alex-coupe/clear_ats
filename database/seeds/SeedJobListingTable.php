<?php

use Illuminate\Database\Seeder;

class SeedJobListingTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\JobListing::class,10)->create();
    }
}
