@extends('layouts.gKecil')
@section('gKecil.body')
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
                    Anda sudah melakukan request Stok, tunggu konfirmasi dari Admin Gudang Besar!
                </div>
                @else
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRequestStok">
                    Purchasing Order
                </button>  
                @endif
                
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
                            <td>{{ $sp->id_produk }}</td>
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
                <form action="/gKecil/request_stok" method="post" class="myForm" enctype="multipart/form-data" id="formToko">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label for="nomorPO" class="form-label">Nomor PO</label>
                            <input type="text" id="nomor_po" name="nomor_po" placeholder="nomor PO" class="form-control"><br>
                        </div>
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
                            <label for="deadlineKirim" class="form-label">Deadline Pengiriman</label>
                            <input type="date" name="deadline_kirim" placeholder="Deadline Pengiriman" class="form-control"><br>
                        </div>
                        <div>
                            <label for="alamatKirim" class="form-label">Alamat Pengiriman</label>
                            <input type="text" name="alamat_kirim" placeholder="Alamat Pengiriman" class="form-control"><br>
                        </div>
                        <div>
                            <label for="catatan" class="form-label">Catatan</label>
                            <input type="text" name="catatan" placeholder="Catatan" class="form-control"><br>
                        </div>
                        <div>
                            <label for="foto" class="form-label">Foto TTD Dokumen</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror"><br>               
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

@endsection
