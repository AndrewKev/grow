<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class GudangBesarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gudang_besar')->delete();
        
        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'B12',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'B16',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'B20',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'BB12',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'BB16',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'BICE16',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'KC',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'KK',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'R12',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_besar')->insert(
            [
                'id_produk' => 'R16',
                'stok' => 0,
                'sample' => 0,
                'harga_stok' =>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
