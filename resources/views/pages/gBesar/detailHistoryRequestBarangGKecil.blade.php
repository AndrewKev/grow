@extends('layouts.gBesar')
@section('gBesar.body')
    <main>
        <a href="/gBesar/history_request_barang_gKecil" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail History Request Barang Gudang Kecil</h3>
        <div class="mt-4">
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        $totalreq = 0;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->req_stok }}</td>
                            </tr>
                            @php
                            $no++;
                            $totalreq += ($dt->req_stok);
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Request</b></label>
            <input type="text" style="text-align: left;" value="{{ $totalreq }}" disabled>
        </div>
        <br><br>
    </main>
@endsection
