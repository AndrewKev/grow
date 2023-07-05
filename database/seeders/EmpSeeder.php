<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('emp')->delete();

        DB::table('emp')->insert(
            [
                'jenis' => 'stiker',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'plano',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'sunscreen',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'gelas230ml',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'gelas400ml',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'tumblr',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'kaos',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'kelender',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('emp')->insert(
            [
                'jenis' => 'lighter',
                'jumlah' => 99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
