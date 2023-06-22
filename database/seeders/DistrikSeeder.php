<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Distrik;

class DistrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('distrik')->delete();

        $csvData = fopen(base_path('database/csv/distrik.csv'), 'r');
        $transRaw = true;

        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (! $transRaw) {
                DB::table('distrik')->insert([
                    'id_distrik' => $data[0],
                    'nama_distrik' => $data[1],
                    'id_user' => $data[2] ?? null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            $transRaw = false;
        }

        fclose($csvData);

        // DB::table('distrik')->insert(
        //     [
        //         'id_distrik' => 'SLMN1',
        //         'nama_distrik' => 'Sleman 1',
        //         'id_user' => '2',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );


        // DB::table('distrik')->insert(
        //     [
        //         'id_distrik' => 'SLMN2',
        //         'nama_distrik' => 'Sleman 2',
        //         'id_user' => '3',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]
        // );


    }
}
