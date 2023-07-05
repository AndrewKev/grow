<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Collection;


class FormProdukController extends Controller
{
    /**
     * Get produk dari Request
     * Kemudian diubah menjadi collection key => value, seperti berikut :
     * [
     *   "idProduk" => "B20"
     *   "jumlah" => "3"
     * ]
     *
     * Return Collection
     */
    public function collectProduk(Request $request): Collection
    {
        $createCollection = collect($request);

        $data = [
            "idProduk" => $createCollection->get('id_produk'),
            "jumlah" => $createCollection->get('jumlah')
        ];

        $newData = collect($data['idProduk'])->map(function ($item, $index) use ($data) {
            return [
                'idProduk' => $item,
                'jumlah' => (int) $data['jumlah'][$index]
            ];
        });

        return new Collection($newData);
    }
}
