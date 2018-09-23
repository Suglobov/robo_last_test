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
            'amount' => rand(10000, 1000000) / 10,
        ]);
        DB::table('users')->insert([
            'amount' => rand(1000, 100000) / 10,
        ]);
        DB::table('users')->insert([
            'amount' => rand(100, 10000) / 10,
        ]);
        DB::table('users')->insert([
            'amount' => rand(10, 1000) / 10,
        ]);
        DB::table('users')->insert([
            'amount' => rand(1, 100) / 10,
        ]);
    }
}
