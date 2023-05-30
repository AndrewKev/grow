@extends('layouts.karyawan')
@section('karyawan.body')
    <div class="mt-4">
        <a href="/user/penjualan_laku_cash" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h2>Detail Penjualan</h2>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Beli</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total = 0;
                    @endphp
                    @foreach ($data as $dt)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $dt->id_produk }}</td>
                            <td>{{ $dt->nama_produk }}</td>
                            <td>{{ $dt->jumlah_produk }}</td>
                            <td>{{ $dt->jumlah_produk * $dt->harga_toko }}</td>
                        </tr>
                        @php
                            $no++;
                            $total += ($dt->jumlah_produk * $dt->harga_toko);
                        @endphp
                    @endforeach
                    <tr>
                        <td colspan="3"><b>Total</b></td>
                        <td><b>{{ $total }}</b></td>
                    </tr>                   
                </tbody>
            </table>
        </div>

    </div>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
