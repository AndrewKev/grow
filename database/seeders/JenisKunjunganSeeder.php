<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisKunjunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_kunjungan')->delete();
        DB::table('jenis_kunjungan')->insert(
            [
                'id_kunjungan' => 'IO',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('jenis_kunjungan')->insert(
            [
                'id_kunjungan' => 'RO',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('jenis_kunjungan')->insert(
            [
                'id_kunjungan' => 'ROC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('jenis_kunjungan')->insert(
            [
                'id_kunjungan' => 'R',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('jenis_kunjungan')->insert(
            [
                'id_kunjungan' => 'STA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
