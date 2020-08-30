<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                'id' => '1',
                'name' => 'admin',
                'email' => 'admin@admin.ru',
                'password' => Hash::make('12345678'),
                'role' => '2'
            ]);
    }
}
