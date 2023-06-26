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
        $csvData = fopen(base_path('database/csv/namaTokoMapping.csv'), 'r');
        $transRaw = true;

        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (! $transRaw) {
                DB::table('toko')->insert([
                    'id_routing' => $data[0],
                    'nama_toko' => (!empty($data[1]) ? $data[1] : null),
                    'id_kunjungan' => (!empty($data[2]) ? $data[2] : null),
                    'latitude' => (!empty($data[3]) ? $data[3] : null),
                    'longitude' => (!empty($data[4]) ? $data[4] : null),
                    'mapping' => (!empty($data[5]) ? $data[5] : null),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            $transRaw = false;
        }

        fclose($csvData);

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '1',
        //         'nama_toko' => 'Toko 1',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );
        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '1',
        //         'nama_toko' => 'Toko 2',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );
        
        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '1',
        //         'nama_toko' => 'Toko 3',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '2',
        //         'nama_toko' => 'Toko 4',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '2',
        //         'nama_toko' => 'Toko 5',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '2',
        //         'nama_toko' => 'Toko 6',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '3',
        //         'nama_toko' => 'Toko 7',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '3',
        //         'nama_toko' => 'Toko 8',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '4',
        //         'nama_toko' => 'Toko 9',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('toko')->insert(
        //     [
        //         'id_routing' => '4',
        //         'nama_toko' => 'Toko 10',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );
    }
}
