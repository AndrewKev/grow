@extends('layouts.spo')
@section('spo.body')
    <div class="mt-5">
        <div class="card mb-4">
            <div class="card-header">
                <h2>STOR PRODUK</h2>
                <div class="mt-4">
                    @if (!$carryToday)
                        <button class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="">
                            Stor Stok Produk
                        </button>
                    @elseif($storToday)
                        <div class="alert alert-info" style="width: fit-content;" role="alert">
                            Anda sudah melakukan stor hari ini! Silahkan '<a href="absensi">Absensi Keluar</a>'!
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
                            $totaljual = 0;
                            $totalharga = 0;
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
                                $totaljual += $sp->terjual;
                                $totalharga += $sp->total_harga;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Penjuamlahan --}}
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total
                    Terjual</b></label>
            <input type="text" style="text-align: left;" value="{{ $totaljual }}" disabled>
        </div>
        <br>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total
                    Harga</b></label>
            <input type="text" style="text-align: left;" value="Rp {{ number_format($totalharga, 0, ',', '.') }}"
                disabled><br><br>
            <input type="hidden" name="" id="totalHarga" value="{{ $totalharga }}">
        </div>
        <!-- Modal Stor Produk -->
        <div class="modal fade" id="modalStorproduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form class="modal-content" action="/spo/request_stor_barang" method="post">
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
                <form class="modal-content" action="/spo/request_stor_uang" method="post">
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
                                <input type="hidden" name="total_harga[]" id="total_harga"
                                    value="{{ $sp->total_harga }}">
                            </div>
                        @endforeach
                        {{-- <label for="totalStor" class="form-label">Total uang yang harus di stor <b>Rp
                                {{ number_format($totalharga, 0, ',', '.') }}</b></label><br><br> --}}

                        <h6>Masukkan Jumlah Uang</h6>
                        <p>Pecahan Uang Kertas : </p>
                        <div>
                            <label for="seratusribu" class="form-label">Rp 100.000</label><br>
                            <input type="number" class="form-control nominal" name="seratusribu" min=0 value="0"
                                id="100k">
                        </div>
                        <div>
                            <label for="limapuluhribu" class="form-label">Rp 50.000</label><br>
                            <input type="number" class="form-control nominal" name="limapuluhribu" min=0 value="0"
                                id="50k">
                        </div>
                        <div>
                            <label for="duapuluhribu" class="form-label">Rp 20.000</label><br>
                            <input type="number" class="form-control nominal" name="duapuluhribu" min=0 value="0"
                                id="20k">
                        </div>
                        <div>
                            <label for="sepuluhribu" class="form-label">Rp 10.000</label><br>
                            <input type="number" class="form-control nominal" name="sepuluhribu" min=0 value="0"
                                id="10k">
                        </div>
                        <div>
                            <label for="limaribu" class="form-label">Rp 5.000</label><br>
                            <input type="number" class="form-control nominal" name="limaribu" min=0 value="0"
                                id="5k">
                        </div>
                        <div>
                            <label for="duaribu" class="form-label">Rp 2.000</label><br>
                            <input type="number" class="form-control nominal" name="duaribu" min=0 value="0"
                                id="2k">
                        </div>
                        <div class="mb-4">
                            <label for="seribu" class="form-label">Rp 1.000</label>
                            <input type="number" class="form-control nominal" name="seribu" min=0 value="0"
                                id="1k">
                        </div>
                        <p class="m-0">Pecahan Uang Koin : </p>
                        <div class="mb-2">
                            <label for="seribukoin" class="form-label">Rp 1.000</label>
                            <input type="number" class="form-control nominal" name="seribukoin" min=0 value="0"
                                id="1000c">
                        </div>
                        <div class="mb-2">
                            <label for="limaratuskoin" class="form-label">Rp 500</label>
                            <input type="number" class="form-control nominal" name="limaratuskoin" min=0 value="0"
                                id="500c">
                        </div>
                        <div class="mb-2">
                            <label for="duaratuskoin" class="form-label">Rp 200</label>
                            <input type="number" class="form-control nominal" name="duaratuskoin" min=0 value="0"
                                id="200c">
                        </div>
                        <div class="mb-2">
                            <label for="seratuskoin" class="form-label">Rp 100</label>
                            <input type="number" class="form-control nominal" name="seratuskoin" min=0 value="0"
                                id="100c">
                        </div>
                    </div>
                    <div class="modal-footer flex-column">
                        <div class="footer-alert">
                            <div class="alert alert-danger d-none" role="alert" id="alertNominalFalse">
                                Nominal pecahan belum sesuai
                            </div>
                            <div class="alert alert-success d-none" role="alert" id="alertNominalTrue">
                                Nominal pecahan sudah sesuai. Klik setuju untuk lanjut.
                            </div>
                        </div>
                        <div class="inner-footer">
                            <div>
                                <div class="d-flex">
                                    <p>Total nominal : </p>
                                    <p class="fw-semibold" id="footerTotal"></p>
                                </div>
                                <div class="d-flex">
                                    <p>Nominal anda : </p>
                                    <p class="fw-semibold" id="footerNominal">Rp 0</p>
                                </div>
                            </div>
                            <div>
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <button type="submit" name="setujuStorUang" class="btn btn-success d-none"
                                    id="btnSetuju">Setuju</button>
                                <button type="button" name="cek" class="btn btn-success" id="cekTotal">Cek Total</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Input Penjualan --}}
        <div class="modal fade" id="modalInputPenjualan" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form class="modal-content" action="/spo/insert_produk" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Selesai Stor Produk?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($storPenjualan as $r)
                            <div>
                                <input type="hidden" name="tanggal_stor_barang[]"
                                    value="{{ $r->tanggal_stor_barang }}">
                                <input type="hidden" name="tanggal_stor_uang[]" value="{{ $r->tanggal_stor_uang }}">
                                <input type="hidden" name="id_produk[]" value="{{ $r->id_produk }}">
                                <input type="hidden" name="stok_awal[]" value="{{ $r->stok_awal }}">
                                <input type="hidden" name="sisa_stok[]" value="{{ $r->sisa_stok }}">
                                <input type="hidden" name="terjual[]" value="{{ $r->terjual }}">
                                <input type="hidden" name="harga_produk[]" value="{{ $r->harga_produk }}">
                                <input type="hidden" name="total_harga[]" value="{{ $r->total_harga }}">
                                <input type="hidden" name="id_rincian_uang[]" value="{{ $r->id_rincian_uang }}">
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

        <script>
            let totalHarga = parseInt(document.getElementById("totalHarga").value);

            document.getElementById('footerTotal').innerHTML = 'Rp ' + totalHarga.toLocaleString('en-US');

            // console.log(totalHarga)

            let buttonCekTotal = document.getElementById("cekTotal");
            buttonCekTotal.addEventListener('click', function() {
                let totalNominal = 0;
                // Get the values from the input fields
                let seratus = parseInt(document.getElementById('100k').value) * 100000;
                let limaPuluh = parseInt(document.getElementById('50k').value) * 50000
                let duaPuluh = parseInt(document.getElementById('20k').value) * 20000;
                let sepuluh = parseInt(document.getElementById('10k').value) * 10000;
                let limaRibu = parseInt(document.getElementById('5k').value) * 5000;
                let duaRibu = parseInt(document.getElementById('2k').value) * 2000;
                let seribu = parseInt(document.getElementById('1k').value) * 1000;
                let seribuKoin = parseInt(document.getElementById('1000c').value) * 1000;
                let limaRatusKoin = parseInt(document.getElementById('500c').value) * 500;
                let duaRatusKoin = parseInt(document.getElementById('200c').value) * 200;
                let seratusKoin = parseInt(document.getElementById('100c').value) * 100;

                let arr = [];
                arr.push(seratus, limaPuluh, duaPuluh, sepuluh, limaRibu, duaRibu, seribu, seribuKoin, limaRatusKoin,
                    duaRatusKoin, seratusKoin);

                // Do something with the values
                for (let i = 0; i < arr.length; i++) {
                    totalNominal += arr[i];
                }
                document.getElementById('footerNominal').innerHTML = 'Rp ' + totalNominal.toLocaleString('en-US');
                // console.log(totalNominal)
                if (totalNominal == totalHarga) {
                    let setuju = document.getElementById('btnSetuju')
                    setuju.classList.remove('d-none')
                    document.getElementById('alertNominalTrue').classList.remove('d-none')
                    document.getElementById('alertNominalFalse').classList.add('d-none')
                    this.classList.add('d-none')
                    document.getElementById('100k').readOnly = true;
                    document.getElementById('50k').readOnly = true;
                    document.getElementById('20k').readOnly = true;
                    document.getElementById('10k').readOnly = true;
                    document.getElementById('5k').readOnly = true;
                    document.getElementById('2k').readOnly = true;
                    document.getElementById('1k').readOnly = true;
                    document.getElementById('1000c').readOnly = true;
                    document.getElementById('500c').readOnly = true;
                    document.getElementById('200c').readOnly = true;
                    document.getElementById('100c').readOnly = true;
                } else {
                    document.getElementById('alertNominalTrue').classList.add('d-none')
                    document.getElementById('alertNominalFalse').classList.remove('d-none')
                }
            });

            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
    @endsection
