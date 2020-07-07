<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123456')
        ]);
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
