<?php

use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permissions')->insert(
            [
             'permission_id' => $faker->numberBetween(0,5), 
             'role_id' => $faker->numberBetween(0,4), 
           ]);
    }
}
