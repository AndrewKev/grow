<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
// use App\Models\TokoSPO;

class TokoSPOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvData = fopen(base_path('database/csv/namaTokoSPO.csv'), 'r');
        $transRaw = true;

        while (($data = fgetcsv($csvData, 555, ',')) !== false) {
            if (! $transRaw) {
                DB::table('toko_spo')->insert([
                    'nama_toko' => $data[0],
                    'alamat' => $data[1],
                    'id_distrik' => $data[2],
                    'ws'=>$data[3],
                    'telepon'=>$data[4],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
            $transRaw = false;
        }

        fclose($csvData);
    }
}
