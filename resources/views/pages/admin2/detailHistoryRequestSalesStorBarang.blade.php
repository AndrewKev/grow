@extends('layouts.admin2')
@section('admin2.body')
    <main>
        <a href="/admin2/history_request_stor_barang" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail Barang History Request Sales Stor Barang</h3>
        <div class="mt-4">
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Stok Awal</th>
                            <th>Terjual</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        $totaljual = 0;
                        $sisastok = 0;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->stok_awal }}</td>
                                <td>{{ $dt->terjual }}</td>
                                <td>{{ $dt->sisa_stok }}</td>
                            </tr>
                            @php
                            $no++;
                            $totaljual += ($dt->terjual);
                            $sisastok += ($dt->sisa_stok);
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Terjual</b></label>
            <input type="text" style="text-align: left;" value="{{ $totaljual }}" disabled>
        </div>
        <br>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Sisa Stok</b></label>
            <input type="text" style="text-align: left;" value="{{ $sisastok }}" disabled>
        </div>
        <br><br>
    </main>
@endsection
