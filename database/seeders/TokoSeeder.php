<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('toko')->delete();

        DB::table('toko')->insert(
            [
                'id_routing' => '1',
                'nama_toko' => 'Toko 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        DB::table('toko')->insert(
            [
                'id_routing' => '1',
                'nama_toko' => 'Toko 2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
        
        DB::table('toko')->insert(
            [
                'id_routing' => '1',
                'nama_toko' => 'Toko 3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '2',
                'nama_toko' => 'Toko 4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '2',
                'nama_toko' => 'Toko 5',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '2',
                'nama_toko' => 'Toko 6',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '3',
                'nama_toko' => 'Toko 7',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '3',
                'nama_toko' => 'Toko 8',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '4',
                'nama_toko' => 'Toko 9',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('toko')->insert(
            [
                'id_routing' => '4',
                'nama_toko' => 'Toko 10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
