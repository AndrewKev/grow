<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        DB::table('users')->insert(
            [
                'nama' => 'admin1',
                'username' => 'admin1',
                'password' => Hash::make('adm001'),
                'level' => 1, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('users')->insert(
            [
                'nama' => 'admin2',
                'username' => 'admin2',
                'password' => Hash::make('adm002'),
                'level' => 2, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('users')->insert(
            [
                'nama' => 'admin3',
                'username' => 'admin3',
                'password' => Hash::make('adm003'),
                'level' => 3, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'gkecil',
                'username' => 'gkecil',
                'password' => Hash::make('kecil004'),
                'level' => 4, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'gbesar',
                'username' => 'gbesar',
                'password' => Hash::make('besar005'),
                'level' => 5, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'pimArea',
                'username' => 'pimArea',
                'password' => Hash::make('area006'),
                'level' => 6, // admin
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Alan',
                'username' => 'Alan',
                'password' => Hash::make('sls001'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Alan2',
                'username' => 'Alan2',
                'password' => Hash::make('sls001'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Fajar',
                'username' => 'Fajar',
                'password' => Hash::make('sls002'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Zanu',
                'username' => 'Zanu',
                'password' => Hash::make('sls003'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        
        // Jogja 1
        DB::table('users')->insert(
            [
                'nama' => 'Antok',
                'username' => 'Antok',
                'password' => Hash::make('sls005'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        // Jogja2
        DB::table('users')->insert(
            [
                'nama' => 'Jaka',
                'username' => 'Jaka',
                'password' => Hash::make('sls004'),
                'level' => 0, // sales
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('users')->insert(
            [
                'nama' => 'HeadAcc',
                'username' => 'HeadAcc',
                'password' => Hash::make('headacc'),
                'level' => 7, // HeadAcc
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('users')->insert(
            [
                'nama' => 'Ferry',
                'username' => 'Ferry',
                'password' => Hash::make('spo001'),
                'level' => 8, // SPO
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('users')->insert(
            [
                'nama' => 'Yudi',
                'username' => 'Yudi',
                'password' => Hash::make('spo002'),
                'level' => 8, // SPO
                'no_telp' => '123',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
