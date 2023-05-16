<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DistrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('distrik')->delete();

        DB::table('distrik')->insert(
            [
                'id_distrik' => 'SLMN1',
                'nama_distrik' => 'Sleman 1',
                'id_user' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('distrik')->insert(
            [
                'id_distrik' => 'SLMN2',
                'nama_distrik' => 'Sleman 2',
                'id_user' => '3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
