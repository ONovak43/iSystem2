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
            'name' => "Ondra",
            'email' => 'ondrej.kt@seznam.cz',
            'password' => bcrypt('test'),
            'type' => "admin",
        ]);
    }
}
