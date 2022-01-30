<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users =
        [
            'admin@123.com' =>
            [
                'name' => 'admin',
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'role_id' => 2
            ],
            'user@123.com' =>
            [
                'name' => 'user',
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'role_id' => 1
            ],
            'superadmin@123.com' =>
            [
                'name' => 'super admin',
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'role_id' => 3
            ],
        ];

        foreach($users as $index => $user){
            DB::table('users')->updateOrInsert(
                ['email' => $index],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'created_at' => $user['created_at'],
                    'updated_at' => $user['updated_at'],
                    'role_id' => $user['role_id']

                ]
            );
        }
    }
}
