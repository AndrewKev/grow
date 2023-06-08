@extends('layouts.karyawan')
@section('karyawan.body')
<div class="mt-5">
    <div class="card mb-4">
        <div class="card-header">
            <h2>STOR PRODUK</h2>
            <div class="mt-4">
                    @if(!$carryToday)
                    <button class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="">
                        Stor Stok Produk
                    </button>
                    @elseif($storToday)
                    <div class="alert alert-info" style="width: fit-content;" role="alert">
                        Anda sudah melakukan stor hari ini! Silahkan 'Absensi Keluar'!
                    </div>
                    @elseif($konfirmasiUang)
                    <div class="alert alert-info" style="width: fit-content;" role="alert">
                        Stor Produk sudah selesai di lakukan! klik tombol 'Selesai' dibawah ini untuk menyelesaikan!
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInputPenjualan">
                        Selesai
                    </button>
                    @elseif($reqUang) 
                    <div class="alert alert-info" style="width: fit-content;" role="alert">
                        Anda sudah request untuk stor kebagian keuangan, silahkan ditunggu proses dari admin!
                    </div>
                    @elseif($konfirmasi)
                    <div class="alert alert-info" style="width: fit-content;" role="alert">
                        Stor Produk sudah dikomfirmasi! lanjutkan stor ke stor keuangan
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStorUang">
                        Stor Hasil Penjualan
                    </button>
                    @elseif ($req)
                        <div class="alert alert-info" style="width: fit-content;" role="alert">
                            Anda sudah request untuk stor barang, silahkan ditunggu proses dari admin!
                        </div>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStorproduk">
                            Stor Stok Produk
                        </button>
                    @endif
                {{-- <a button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStorproduk">
                    Stor Stok Produk
                </a> --}}
            </div>
        </div>
        <div class="card-body">
            {{-- <a href="#">History</a> --}}
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Stok Awal</th>
                        <th>Sisa Stok</th>
                        <th>Terjual</th>
                        <th>Harga Produk</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($storproduk as $sp)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $sp->tanggal_carry }}</td>
                            <td>{{ $sp->nama_produk }}</td>
                            <td>{{ $sp->stok_awal }}</td>
                            <td>{{ $sp->stok_sekarang }}</td>
                            <td>{{ $sp->terjual }}</td>
                            <td>{{ $sp->harga_toko }}</td>
                            <td>{{ $sp->total_harga }}</td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal Stor Produk -->
    <div class="modal fade" id="modalStorproduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/user/request_stor_barang" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Stor Stok Produk?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($storproduk as $sp)
                        <div>
                            <input type="hidden" name="tanggal_carry[]" value="{{ $sp->tanggal_carry }}">
                            <input type="hidden" name="id_produk[]" value="{{ $sp->id_produk }}">
                            <input type="hidden" name="nama_produk[]" value="{{ $sp->nama_produk }}">
                            <input type="hidden" name="stok_awal[]" value="{{ $sp->stok_awal }}">
                            <input type="hidden" name="stok_sekarang[]" value="{{ $sp->stok_sekarang }}">
                            <input type="hidden" name="terjual[]" value="{{ $sp->terjual }}">
                            <input type="hidden" name="harga_toko[]" value="{{ $sp->harga_toko }}">
                            <input type="hidden" name="total_harga[]" value="{{ $sp->total_harga }}">

                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" name="setujuStorProduk" class="btn btn-success">Setuju</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Stor Uang --}}
    <div class="modal fade" id="modalStorUang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/user/request_stor_uang" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Stor Hasil Penjualan?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($storproduk as $sp)
                        <div>
                            <input type="hidden" name="tanggal_carry[]" value="{{ $sp->tanggal_carry }}">
                            <input type="hidden" name="id_produk[]" value="{{ $sp->id_produk }}">
                            <input type="hidden" name="nama_produk[]" value="{{ $sp->nama_produk }}">
                            <input type="hidden" name="stok_awal[]" value="{{ $sp->stok_awal }}">
                            <input type="hidden" name="stok_sekarang[]" value="{{ $sp->stok_sekarang }}">
                            <input type="hidden" name="terjual[]" value="{{ $sp->terjual }}">
                            <input type="hidden" name="harga_toko[]" value="{{ $sp->harga_toko }}">
                            <input type="hidden" name="total_harga[]" value="{{ $sp->total_harga }}">

                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" name="setujuStorUang" class="btn btn-success">Setuju</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Input Penjualan --}}
    <div class="modal fade" id="modalInputPenjualan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/user/insert_produk" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Selesai Stor Produk?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($storproduk as $sp)
                        <div>
                            <input type="hidden" name="tanggal_carry[]" value="{{ $sp->tanggal_carry }}">
                            <input type="hidden" name="id_produk[]" value="{{ $sp->id_produk }}">
                            <input type="hidden" name="nama_produk[]" value="{{ $sp->nama_produk }}">
                            <input type="hidden" name="stok_awal[]" value="{{ $sp->stok_awal }}">
                            <input type="hidden" name="stok_sekarang[]" value="{{ $sp->stok_sekarang }}">
                            <input type="hidden" name="terjual[]" value="{{ $sp->terjual }}">
                            <input type="hidden" name="harga_toko[]" value="{{ $sp->harga_toko }}">
                            <input type="hidden" name="total_harga[]" value="{{ $sp->total_harga }}">

                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" name="batalinsert" class="btn btn-danger" >Batal</button> --}}
                    <button type="submit" name="setujuinsert" class="btn btn-success">Selesai</button>
                </div>
            </form>
        </div>
    </div>
@endsection
