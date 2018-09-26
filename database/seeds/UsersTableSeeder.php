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
        $u1 = DB::table('users')->insertGetId([
            'amount' => rand(10000, 1000000) / 10,
        ]);
        $u2 = DB::table('users')->insertGetId([
            'amount' => rand(1000, 100000) / 10,
        ]);
        $u3 = DB::table('users')->insertGetId([
            'amount' => rand(100, 10000) / 10,
        ]);
        $u4 = DB::table('users')->insertGetId([
            'amount' => rand(10, 1000) / 10,
        ]);
        $u5 = DB::table('users')->insertGetId([
            'amount' => rand(1, 100) / 10,
        ]);

        $d1 = date('Y-m-d H:0:0', strtotime('+' . mt_rand(10, 300) . ' hours'));
        $d2 = date('Y-m-d H:0:0', strtotime('+' . mt_rand(10, 300) . ' hours'));
        $d3 = date('Y-m-d H:0:0', strtotime('+' . mt_rand(10, 300) . ' hours'));
        $d4 = date('Y-m-d H:0:0', strtotime('+' . mt_rand(10, 300) . ' hours'));
        DB::table('defferred_operations')->insert([
            'user_id_from'        => $u1,
            'user_id_to'          => $u2,
            'amount'              => rand(1000, 10000) / 10,
            'operation_datetime'  => $d1,
            'operation_completed' => false,
        ]);
        DB::table('defferred_operations')->insert([
            'user_id_from'        => $u1,
            'user_id_to'          => $u2,
            'amount'              => rand(100, 1000) / 10,
            'operation_datetime'  => $d2,
            'operation_completed' => false,
        ]);
        DB::table('defferred_operations')->insert([
            'user_id_from'        => $u2,
            'user_id_to'          => $u3,
            'amount'              => rand(100, 1000) / 10,
            'operation_datetime'  => $d3,
            'operation_completed' => false,
        ]);
        DB::table('defferred_operations')->insert([
            'user_id_from'        => $u3,
            'user_id_to'          => $u4,
            'amount'              => rand(10, 100) / 10,
            'operation_datetime'  => $d4,
            'operation_completed' => false,
        ]);
    }
}
