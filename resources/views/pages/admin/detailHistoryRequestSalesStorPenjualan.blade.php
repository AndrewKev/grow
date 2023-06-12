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
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
