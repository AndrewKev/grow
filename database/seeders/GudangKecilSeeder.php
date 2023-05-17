<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GudangKecilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gudang_kecil')->delete();
        
        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'B12',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'B16',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'B20',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'BB12',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'BB16',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'BICE16',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'KC',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'KK',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'R12',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('gudang_kecil')->insert(
            [
                'id_produk' => 'R16',
                'stok' => 200,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
