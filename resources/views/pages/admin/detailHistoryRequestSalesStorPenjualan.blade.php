@extends('layouts.admin')
@section('admin.body')
    <main>
        <a href="/admin/history_request_stor_penjualan" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail History Request Sales Stor Penjualan</h3>
        <div class="mt-4">
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Terjual</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        $totaljual = 0;
                        $totalharga = 0;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->terjual }}</td>
                                <td>{{ $dt->total_harga }}</td>
                            </tr>
                            @php
                            $no++;
                            $totaljual += ($dt->terjual);
                            $totalharga += ($dt->total_harga);
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
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Harga</b></label>
            <input type="text" style="text-align: left;" value="Rp {{ number_format($totalharga, 0, ',', '.') }}" disabled><br><br>
        </div>
    </main>
@endsection
