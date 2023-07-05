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
            <div>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalCloseSpo">Close SPO</button>
            </div>
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
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Beli</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalCloseSpo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/spo/penjualan_spo" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Close SPO From</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>hehe</h3>
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
