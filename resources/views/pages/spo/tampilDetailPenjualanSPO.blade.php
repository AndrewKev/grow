@extends('layouts.spo')
@section('spo.body')
    <div class="mt-4">
        <a href="/spo/penjualan_spo" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h2>Detail Penjualan Toko : {{ $toko->nama_toko }}</h2>
    </div>

    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h4>SPO New</h4>
        </div>
        <div class="card-body">
            <table id="datatableSpoNew" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Beli</th>
                        {{-- <th>Total Harga</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total = 0;
                        $totalbeli = 0;
                    @endphp
                    @foreach ($data as $dt)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $dt->id_produk }}</td>
                            <td>{{ $dt->nama_produk }}</td>
                            <td>{{ $dt->jumlah_produk }}</td>
                            {{-- <td>Rp {{ number_format($dt->jumlah_produk * $dt->harga_toko, 0, ',', '.') }}</td> --}}
                        </tr>
                        @php
                            $no++;
                            $total += $dt->jumlah_produk * $dt->harga_toko;
                            $totalbeli += $dt->jumlah_produk;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            @if (!$closed->count() > 0)
                <div>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#modalCloseSpo">Close
                        SPO</button>
                </div>
            @endif
        </div>
    </div>

    <div style="text-align: right;">
        <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Beli</b></label>
        <input type="text" style="text-align: left;" value="{{ $totalbeli }}" disabled>
    </div>
    <br>
    {{-- <div style="text-align: right;">
        <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Harga</b></label>
        <input type="text" style="text-align: left;" value="Rp {{ number_format($total, 0, ',', '.') }}"
            disabled><br><br>
    </div> --}}

    @if ($closed->count() > 0)
        <div>
            <div class="card mb-4 mt-4">
                <div class="card-header">
                    <h4>SPO Close</h4>
                </div>
                <div class="card-body">
                    <table id="datatableSpoClose" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal SPO Close</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Stok Kembali</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($closed as $cls)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $cls['tanggal_close_spo'] }}</td>
                                    <td>{{ $cls['id_produk'] }}</td>
                                    <td>{{ $cls['nama_produk'] }}</td>
                                    <td>{{ $cls['jumlah_produk'] }}</td>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal fade" id="modalCloseSpo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/spo/spo_close/{{ $toko->id }}" enctype="multipart/form-data"
                method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Close SPO From</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Pengembalian Stok</h5>
                    @if (!empty($data))
                        @foreach ($data as $dt)
                            <div class="mb-3">
                                <label for="{{ $dt->id_produk }}" class="form-label">{{ $dt->nama_produk }}</label>
                                <input min="0" max="{{ $dt->jumlah_produk }}" value="0" type="number"
                                    id="_{{ $dt->id_produk }}" name="jumlah[]" placeholder="{{ $dt->id_produk }}"
                                    class="form-control">
                                {{-- <div>
                                    <span class="text-success">Stok produk ini : {{ $dt['stokSekarang'] }}</span>
                                </div> --}}
                                {{-- <div class="d-none" id="valid_{{ $dt->id_produk }}">
                                    <span class="text-danger">Stok tidak cukup</span>
                                </div> --}}
                                {{-- <input type="hidden" data-input-id="stok{{ $dt->id_produk }}"
                                    value="{{ $dt['stokSekarang'] }}"> --}}
                                <input type="hidden" name="id_produk[]" value="{{ $dt->id_produk }}">
                            </div>
                        @endforeach
                    @else
                        <div>Data tidak ditemukan.</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                    {{-- <button type="submit" name="setuju" class="btn btn-success" onclick="return confirm('Terima barang?')">Setuju</button> --}}
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal -->



    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
