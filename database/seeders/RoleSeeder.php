<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = ['user','admin','superadmin'];

        foreach($roles as $key => $role){

            DB::table('roles')->updateOrInsert(
                [
                    'id' => $key +1
                ],
                [
                    'name' => $role
                ]
            );
        }
    }
}
