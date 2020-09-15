<?php

use Illuminate\Database\Seeder;

class RecruitersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Recruiter::class, 10)->create();
    }
}
