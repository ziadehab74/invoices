<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::factory()->create([
            'name'=>'ziad ehab',
            'email'=>'zehab028@gmail.com',
            'password'=>Hash::make('123456789'),
            'roles_name'=>'Admin',
            'Status'=>'1'
        ]);

    }
}
