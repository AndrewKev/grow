@extends('layouts.admin2')
@section('admin2.body')
<div class="mt-5">
    <div class="card mb-4">
        <div class="card-header">
            <h2>STOK GUDANG KECIL</h2>
        </div>
        <div class="card-body">
            {{-- <a href="#">History</a> --}}
            <div class="my-2">
                @if ($requestBarang)
                <div class="alert alert-info" style="width: fit-content;" role="alert">
                    Anda sudah melakukan request Stok, tunggu konfirmasi dari Pimpinan Area!
                </div>
                @elseif($accGBesar)
                <div class="alert alert-info" style="width: fit-content;" role="alert">
                    Barang anda sudah dikonfirmasi Gudang Besar!
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCekBarang">
                    Cek Barang
                </button>
                @elseif($accPimArea)
                <div class="alert alert-info" style="width: fit-content;" role="alert">
                    Pimpinan Area ACC, tunggu stok dikirim Gudang Besar
                </div>
                @elseif($isTodayReq)
                <div class="alert alert-info" style="width: fit-content;" role="alert">
                    Anda sudah melakukan request hari ini
                </div>
                @else
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRequestStok">
                    Purchasing Order
                </button>  
                @endif
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRequestStok">
                    Purchasing Order
                </button> --}}
                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRequestSample">
                    Request Sample
                </button> --}}
            </div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Sample</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($stokSample as $sp)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $sp->nama_produk }}</td>
                            <td>{{ $sp->stok }}</td>
                            <td>{{ $sp->sample }}</td>
                        </tr>
                        @php
                        $no++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalRequestStok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Purchasing Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/admin2/request_stok" method="post" class="myForm" enctype="multipart/form-data" id="formToko">
                    @csrf
                    <div class="modal-body">
                        
                        <div>
                            <label for="b20" class="form-label">GROW BOLD 20</label>
                            <input type="number" id="B20" name="produk[]" placeholder="B20" class="form-control"
                                value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="B20">
                            <input type="hidden" name="nama_produk[]" value="GROW BOLD 20">
                        </div>
                        <div>
                            <label for="b16" class="form-label">GROW BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="B16" class="form-control" value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="B16">
                            <input type="hidden" name="nama_produk[]" value="GROW BOLD 16">
                        </div>
                        <div>
                            <label for="b12" class="form-label">GROW BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="B12" class="form-control" value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="B12">
                            <input type="hidden" name="nama_produk[]" value="GROW BOLD 12">
                        </div>
                        <div>
                            <label for="r16" class="form-label">GROW REG 16</label>
                            <input type="number" name="produk[]" placeholder="R16" class="form-control" value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="R16">
                            <input type="hidden" name="nama_produk[]" value="GROW REG 16">
                        </div>
                        <div>
                            <label for="r12" class="form-label">GROW REG 12</label>
                            <input type="number" name="produk[]" placeholder="R12" class="form-control" value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="R12">
                            <input type="hidden" name="nama_produk[]" value="GROW REG 12">
                        </div>
                        <div>
                            <label for="kk" class="form-label">GROW KRETEK KUNING 12</label>
                            <input type="number" name="produk[]" placeholder="KK" class="form-control" value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="KK">
                            <input type="hidden" name="nama_produk[]" value="GROW KRETEK KUNING 12">
                        </div>
                        <div>
                            <label for="kc" class="form-label">GROW KRETEK COKLAT 12</label>
                            <input type="number" name="produk[]" placeholder="KC" class="form-control"
                                value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="KC">
                            <input type="hidden" name="nama_produk[]" value="GROW KRETEK COKLAT 12">
                        </div>
                        <div>
                            <label for="bb16" class="form-label">GROW BERRY BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="BB16" class="form-control"
                                value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="BB16">
                            <input type="hidden" name="nama_produk[]" value="GROW BERRY BOLD 16">
                        </div>
                        <div>
                            <label for="bb12" class="form-label">GROW BERRY BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="BB12" class="form-control"
                                value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="BB12">
                            <input type="hidden" name="nama_produk[]" value="GROW BERRY BOLD 12">
                        </div>
                        <div>
                            <label for="bice" class="form-label">GROW BLACK ICE 16</label>
                            <input type="number" name="produk[]" placeholder="BICE16" class="form-control"
                                value="0" min="0"><br>
                            <input type="hidden" name="id_produk[]" value="BICE16">
                            <input type="hidden" name="nama_produk[]" value="GROW BLACK ICE 16">
                        </div>
                        <div>
                            <label for="catatan" class="form-label">Catatan</label>
                            <input type="text" name="catatan" placeholder="Catatan" value="{{ old('catatan', '-') }}" class="form-control"><br>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal Cek Barang -->
    <div class="modal fade" id="modalCekBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/admin2/terima_barang" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($barangKonfirmasi as $brg)
                        <div>
                            <label class="form-label">{{ $brg->nama_produk }}</label>
                            <input min="0" type="number" placeholder=""
                                class="form-control" value="{{ $brg->stok }}" disabled><br>
                            <input type="hidden" name="id_produk[]" value="{{ $brg->id_produk }}">
                            <input type="hidden" name="nama_produk[]" value="{{ $brg->nama_produk }}">
                            <input type="hidden" name="jumlah[]" value="{{ $brg->stok }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" name="setuju" class="btn btn-success" onclick="return confirm('Terima barang?')">Setuju</button>
                </div>
            </form>
        </div>
    </div>
@endsection
