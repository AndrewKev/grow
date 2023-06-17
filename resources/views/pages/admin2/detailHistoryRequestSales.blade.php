@extends('layouts.admin2')
@section('admin2.body')
    <main>
        <a href="/admin2/history_request_sales" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail Barang History Request Sales</h3>
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
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->jumlah }}</td>
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
