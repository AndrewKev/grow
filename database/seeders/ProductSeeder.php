<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->delete();
        
        DB::table('products')->insert(
            [
                'id_produk' => 'B12',
                'nama_produk' => 'GROW BOLD 12',
                'harga_toko' => 13500,
                'harga_grosir' => 13300,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'B16',
                'nama_produk' => 'GROW BOLD 16',
                'harga_toko' => 17500,
                'harga_grosir' => 17300,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'B20',
                'nama_produk' => 'GROW BOLD 20',
                'harga_toko' => 21200,
                'harga_grosir' => 21000,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'BB12',
                'nama_produk' => 'GROW BERY BOLD 12',
                'harga_toko' => 15500,
                'harga_grosir' => 15300,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'BB16',
                'nama_produk' => 'GROW BERY BOLD 16',
                'harga_toko' => 15500,
                'harga_grosir' => 15300,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'BICE16',
                'nama_produk' => 'GROW BLACK ICE 16',
                'harga_toko' => 17700,
                'harga_grosir' => 17500,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'KC',
                'nama_produk' => 'GROW KRETEK COKLAT 12',
                'harga_toko' => 6800,
                'harga_grosir' => 6600,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'KK',
                'nama_produk' => 'GROW KRETEK KUNING 12',
                'harga_toko' => 6800,
                'harga_grosir' => 6600,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'R12',
                'nama_produk' => 'GROW REG 12',
                'harga_toko' => 13500,
                'harga_grosir' => 13300,
            ]
        );

        DB::table('products')->insert(
            [
                'id_produk' => 'R16',
                'nama_produk' => 'GROW REG 16',
                'harga_toko' => 17500,
                'harga_grosir' => 17300,
            ]
        );
    }
}
