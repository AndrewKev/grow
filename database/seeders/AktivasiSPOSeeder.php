<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AktivasiSPOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path('database/csv/SPOAreaKota.csv'), 'r');
        $transRaw = true;

        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (! $transRaw) {
                DB::table('aktivasi_spo')->insert([
                    'id_toko' => $data[0],
                    'aktivasi' => $data[1],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            $transRaw = false;
        }

        fclose($csvData);
    }
}
