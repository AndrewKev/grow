<?php

namespace App\Http\Controllers;

use App\Models\Emp;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EmpController extends Controller
{
    /**
     * Get emp dari Request
     * Kemudian diubah menjadi collection key => value, seperti berikut :
     * [
     *   "emp" => "plano"
     *   "jumlah" => "3"
     * ]
     * Return Collection
     */
    public function collectEmp(Request $request): Collection
    {
        $createCollection = collect($request);

        $data = [
            "emp" => $createCollection->get('emp'),
            "jumlah" => $createCollection->get('jumlahEmp')
        ];

        $newData = collect($data['emp'])->map(function ($item, $index) use ($data) {
            return [
                'emp' => $item,
                'jumlah' => (int) $data['jumlah'][$index]
            ];
        });

        return new Collection($newData);
    }

    /**
     * Update stok EMP pada database.
     * Return void;
     */
    public function updateStok(Request $request): void
    {
        $datas = $this->collectEmp($request);

        $datas->map(function ($item, $key) {
            $totalStokEmp = Emp::where('jenis', $item['emp'])->first()->jumlah;
            Emp::where('jenis', $item['emp'])->update(['jumlah' => $totalStokEmp - $item['jumlah']]);
        });
    }

    /**
     * Proses EMP seperti update database dan return nilai : "stiker(2);plano(3)"
     * Return string.
     */
    public function proccessEmp(Request $request): string
    {
        $datas = $this->collectEmp($request);
        $emp = "";

        $datas->map(function ($item, $key) use (&$emp) {
            return $emp .= $item['emp'] . '(' . $item['jumlah'] . ')' . ';';
        });

        $this->updateStok($request);

        return $emp;
    }
}
