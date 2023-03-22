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
            'name' => 'user01',
            'email' => 'user01@gmail.com',
            'password' => bcrypt('A712247a'),
        ];
        User::create($param);
        $param = [
            'permission_id' => 2,
            'name' => 'user02',
            'email' => 'user02@gmail.com',
            'password' => bcrypt('A712247a'),
        ];
        User::create($param);
        $param = [
            'permission_id' => 3,
            'name' => 'user03',
            'email' => 'user03@gmail.com',
            'password' => bcrypt('A712247a'),
        ];
        User::create($param);
    }
}
