<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'regular',
        ];
        Permission::create($param);
        $param = [
            'name' => 'premium',
        ];
        Permission::create($param);
        $param = [
            'name' => 'manager',
        ];
        Permission::create($param);
    }
}
