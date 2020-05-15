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
        $this->call(RecruitersTableSeeder::class);
        $this->call(CompanyAddressTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
    }
}
