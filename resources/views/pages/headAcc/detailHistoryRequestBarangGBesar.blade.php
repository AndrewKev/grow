@extends('layouts.headAcc')
@section('headAcc.body')
    <main>
        <a href="/headAcc/history_request_barang_gBesar" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail History Request Barang Gudang Besar</h3>
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
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        $totalreq = 0;
                        $hargastok = 0;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->req_stok }}</td>
                                <td>Rp {{ number_format($dt->harga_stok, 0, ',', '.') }}</td>
                            </tr>
                            @php
                            $no++;
                            $totalreq += ($dt->req_stok);
                            $hargastok += ($dt->harga_stok);
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
        <br>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Harga Request</b></label>
            <input type="text" style="text-align: left;" value="Rp {{ number_format($hargastok, 0, ',', '.') }}" disabled>
        </div>
        <br><br>
    </main>
@endsection
