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
        DB::table('routing')->delete();

        DB::table('routing')->insert(
            [
                'nama_routing' => 'Routing 1',
                'id_distrik' => 'SLMN1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('routing')->insert(
            [
                'nama_routing' => 'Routing 2',
                'id_distrik' => 'SLMN1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('routing')->insert(
            [
                'nama_routing' => 'Routing 1',
                'id_distrik' => 'SLMN2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );

        DB::table('routing')->insert(
            [
                'nama_routing' => 'Routing 2',
                'id_distrik' => 'SLMN2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }
}
