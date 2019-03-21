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
            'name' => 'Masud',
            'email' => 'mr@gmail.com',
            'password' => bcrypt('afafafaf'),
        ]);

        DB::table('users')->insert([
            'name' => 'Darjush',
            'email' => 'dk@gmail.com',
            'password' => bcrypt('afafafaf'),
        ]);
    }
}
