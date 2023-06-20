@extends('layouts.headAcc')
@section('headAcc.body')
    <main>
        <a href="/headAcc/request_gudang_besar" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <div class="mt-4">
            <form action="{{ $user[0]->id }}/konfirmasi" method="post" onsubmit="return confirm('Konfirmasi Request Gudang Besar?')">
                @csrf
                @foreach ($dataBarangKonfirmasi as $index => $brg)
                    <input type="hidden" name="id_produk[{{ $index }}]" value="{{ $brg->id_produk }}">
                    <input type="hidden" name="nama_produk[{{ $index }}]" value="{{ $brg->nama_produk }}">
                    <input type="hidden" name="stok[{{ $index }}]" value="{{ $brg->stok }}">
                @endforeach
                <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalKurangStok">
                    Konfirmasi
                </button>
            </form>              
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
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
                                <td>{{ $dt->created_at }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->stok }}</td>
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
