<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoutingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('routing')->delete();

        $csvData = fopen(base_path('database/csv/routing.csv'), 'r');
        $transRaw = true;

        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (! $transRaw) {
                DB::table('routing')->insert([
                    'id_distrik' => $data[0],
                    'nama_routing' => $data[1],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            $transRaw = false;
        }

        fclose($csvData);

        // DB::table('routing')->insert(
        //     [
        //         'nama_routing' => 'Routing 1',
        //         'id_distrik' => 'SLMN1',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('routing')->insert(
        //     [
        //         'nama_routing' => 'Routing 2',
        //         'id_distrik' => 'SLMN1',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('routing')->insert(
        //     [
        //         'nama_routing' => 'Routing 1',
        //         'id_distrik' => 'SLMN2',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );

        // DB::table('routing')->insert(
        //     [
        //         'nama_routing' => 'Routing 2',
        //         'id_distrik' => 'SLMN2',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );
    }
}
