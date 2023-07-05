<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;

class AbsensiKeluar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:absensi-keluar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(); // Ganti dengan model pengguna yang sesuai di aplikasi Anda
    
        foreach ($users as $user) {
            $lastAbsensi = DB::select("SELECT * FROM absensi 
                                        WHERE id_user = $user->id 
                                        AND waktu_keluar IS NULL LIMIT 1;");
            if (!empty($lastAbsensi)) {
                $absensiId = $lastAbsensi[0]->id_user;
                $timeNow = date('Y-m-d H:i:s'); // Waktu saat ini dalam format Y-m-d H:i:s

                // Periksa apakah waktu keluar belum mencapai tengah malam
                $query = DB::update( "UPDATE absensi SET waktu_keluar = CONCAT(DATE(waktu_masuk), ' 23:59:59') WHERE id_user = $absensiId AND waktu_keluar IS NULL");
                // DB::update($query);
            }
        }
    }
}
