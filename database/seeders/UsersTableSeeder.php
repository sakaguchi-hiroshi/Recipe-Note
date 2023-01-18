<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'permission_id' => 1,
            'name' => '坂口博史',
            'email' => 'nohoho0320@gmail.com',
            'password' => bcrypt('A712247a'),
        ];
        User::create($param);
        $param = [
            'permission_id' => 2,
            'name' => '坂口博史',
            'email' => 'nohoho0320@icloud.com',
            'password' => bcrypt('A712247a'),
        ];
        User::create($param);
        $param = [
            'permission_id' => 3,
            'name' => '坂口博史',
            'email' => 'nohoho0320@example.com',
            'password' => bcrypt('A712247a'),
        ];
        User::create($param);
    }
}
