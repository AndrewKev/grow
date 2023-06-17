@extends('layouts.admin')
@section('admin.body')
    <main>
        <a href="/admin/request_stor_uang" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail Barang Request Sales : {{ $sales[0]->nama }}</h3>
        <div class="mt-4">
            <form action="{{ $sales[0]->id }}/konfirmasi" method="post"
                onsubmit="return confirm('Konfirmasi Request Sales?')">
                @csrf
                <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editkm">
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
                            <th>Terjual</th>
                            <th>Harga Barang</th>
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
                                <td>{{ $dt->tanggal_stor_uang }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->terjual }}</td>
                                <td>{{ $dt->harga_produk }}</td>
                                <td>{{ $dt->total_harga }}</td>
                            </tr>
                            @php
                                $no++;
                                $totaljual += $dt->terjual;
                                $totalharga += $dt->total_harga;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total
                    Terjual</b></label>
            <input type="text" style="text-align: left;" value="{{ $totaljual }}" disabled>
        </div>
        <br>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Sisa
                    Stok</b></label>
            <input type="text" style="text-align: left;" value="Rp {{ number_format($totalharga, 0, ',', '.') }}"
                disabled><br><br>
        </div>
        <div class="card mb-4 mt-4">
            <div class="m-4">
                <h2>Detail Nominal Pecahan</h2>
            </div>
            <div class="card-body">
                <div>
                    <div>
                        <h4>Kertas</h4>
                    </div>
                    <table id="tableNominalKertas">
                        <thead>
                            <tr>
                                <th>Nominal</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rp 100,000</td>
                                <td>{{ $data[0]->seratus_ribu }}</td>
                            </tr>
                            <tr>
                                <td>Rp 50,000</td>
                                <td>{{ $data[0]->lima_puluh_ribu }}</td>
                            </tr>
                            <tr>
                                <td>Rp 20,000</td>
                                <td>{{ $data[0]->dua_puluh_ribu }}</td>
                            </tr>
                            <tr>
                                <td>Rp 10,000</td>
                                <td>{{ $data[0]->sepuluh_ribu }}</td>
                            </tr>
                            <tr>
                                <td>Rp 5,000</td>
                                <td>{{ $data[0]->lima_ribu }}</td>
                            </tr>
                            <tr>
                                <td>Rp 2,000</td>
                                <td>{{ $data[0]->dua_ribu }}</td>
                            </tr>
                            <tr>
                                <td>Rp 1,000</td>
                                <td>{{ $data[0]->seribu }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <div>
                        <h4>Koin</h4>
                    </div>
                    <table id="tableNominalKoin">
                        <thead>
                            <tr>
                                <th>Nominal</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Rp 1,000</td>
                                <td>{{ $data[0]->seribu_koin }}</td>
                            </tr>
                            <tr>
                                <td>Rp 500</td>
                                <td>{{ $data[0]->lima_ratus_koin }}</td>
                            </tr>
                            <tr>
                                <td>Rp 200</td>
                                <td>{{ $data[0]->dua_ratus_koin }}</td>
                            </tr>
                            <tr>
                                <td>Rp 100</td>
                                <td>{{ $data[0]->seratus_koin }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div style="text-align: left;">
            <label style="font-weight: bold;"><b>RINCIAN STOR UANG</b></label><br><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>KERTAS</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 100.000 :
                    {{ $data[0]->seratus_ribu }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 50.000 :
                    {{ $data[0]->lima_puluh_ribu }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 20.000 :
                    {{ $data[0]->dua_puluh_ribu }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 10.000 :
                    {{ $data[0]->sepuluh_ribu }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 5.000 :
                    {{ $data[0]->lima_ribu }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 2.000 :
                    {{ $data[0]->dua_ribu }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 1.000 :
                    {{ $data[0]->seribu }}</b></label><br><br>

            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>KOIN</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 1.000 :
                    {{ $data[0]->seribu_koin }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 500 :
                    {{ $data[0]->lima_ratus_koin }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 200 :
                    {{ $data[0]->dua_ratus_koin }}</b></label><br>
            <label style="display: inline-block; width: 150px; font-weight: bold;"><b>Rp 100 :
                    {{ $data[0]->seratus_koin }}</b></label><br><br><br>
        </div> --}}
    </main>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        define(['jquery'], function($) {
            return factory($, window, document);
        });

        $(document).ready(function() {
            $('#tableNominal').DataTable();
        });
    </script>
@endsection
