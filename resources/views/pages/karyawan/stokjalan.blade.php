@extends('layouts.karyawan')
@section('karyawan.body')
    <div class="card mb-4">
        <div class="card-header">
            <h2>STOK JALAN</h2>
        </div>
        <div class="card-body">
            {{-- <a href="#">History</a> --}}
            <div class="my-2">
                @if (!$isCarry)
                    @if ($konfirmasi)
                        <div class="alert alert-info" style="width: fit-content;" role="alert">
                            Barang anda sudah dikonfirmasi admin!
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCekBarang">
                            Cek Barang
                        </button>
                    @elseif ($req)
                        <div class="alert alert-info" style="width: fit-content;" role="alert">
                            Anda sudah request barang, silahkan ditunggu proses dari admin!
                        </div>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAmbilBarang">
                            Request Barang
                        </button>
                    @endif
                @endif
            </div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Stok dibawa</th>
                        <th>Stok kembali</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($barang as $brg)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $brg->tanggal_carry }}</td>
                            <td>{{ $brg->nama_produk }}</td>
                            <td>{{ $brg->stok_dibawa }}</td>
                            <td></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editkm">
                                    Edit
                                </button>
                            </td>
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
    <div class="modal fade" id="modalAmbilBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/user/request_barang" method="post" class="myForm" enctype="multipart/form-data" id="formToko">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label for="b20" class="form-label">GROW BOLD 20</label>
                            <input type="number" id="B20" name="produk[]" placeholder="B20" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B20">
                        </div>
                        <div>
                            <label for="b16" class="form-label">GROW BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="B16" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B16">
                        </div>
                        <div>
                            <label for="b12" class="form-label">GROW BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="B12" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B12">
                        </div>
                        <div>
                            <label for="r16" class="form-label">GROW REG 16</label>
                            <input type="number" name="produk[]" placeholder="R16" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="R16">
                        </div>
                        <div>
                            <label for="r12" class="form-label">GROW REG 12</label>
                            <input type="number" name="produk[]" placeholder="R12" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="R12">
                        </div>
                        <div>
                            <label for="kk" class="form-label">GROW KRETEK KUNING 12</label>
                            <input type="number" name="produk[]" placeholder="KK" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="KK">
                        </div>
                        <div>
                            <label for="kc" class="form-label">GROW KRETEK COKLAT 12</label>
                            <input type="number" name="produk[]" placeholder="KC" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="KC">
                        </div>
                        <div>
                            <label for="bb16" class="form-label">GROW BERRY BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="BB16" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="BB16">
                        </div>
                        <div>
                            <label for="bb12" class="form-label">GROW BERRY BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="BB12" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="BB12">
                        </div>
                        <div>
                            <label for="bice" class="form-label">GROW BLACK ICE 16</label>
                            <input type="number" name="produk[]" placeholder="BICE16" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="BICE16">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Cek Barang -->
    <div class="modal fade" id="modalCekBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/user/terima_barang" method="post">
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
                                class="form-control" value="{{ $brg->jumlah }}" disabled><br>
                            <input type="hidden" name="id_produk[]" value="{{ $brg->id_produk }}">
                            <input type="hidden" name="jumlah[]" value="{{ $brg->jumlah }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" name="batal" class="btn btn-danger" onclick="return confirm('Yakin tidak ingin menerima barang?')">Batal</button>
                    <button type="submit" name="setuju" class="btn btn-success" onclick="return confirm('Terima barang?')">Setuju</button>
                </div>
            </form>
        </div>
    </div>
@endsection
