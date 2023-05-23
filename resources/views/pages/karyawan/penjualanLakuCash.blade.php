@extends('layouts.karyawan')
@section('karyawan.body')
    <h2 class="mb-4 mt-4">Penjualan</h2>
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenjualanLakuCash">
                Penjualan
            </button>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Sales</th>
                        <th>Distrik</th>
                        <th>Jenis Kunjungan</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Beli</th>
                        <th>Harga</th>
                        <th>EMP</th>
                        <th>Keterangan</th>
                        <th>Foto</th>
                        <th>GeoLocation</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalPenjualanLakuCash" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/user/penjualanLakuCash" method="post" class="myForm" enctype="multipart/form-data" id="formToko">
                    @csrf
                    <div class="modal-body">
                        <div>
                            <label for="nama" class="form-label">Nama</label><br>
                            <input type="text" name="nama" value="{{ auth()->user()->nama }}" class="form-control" readonly><br>
                        </div>
                        <div>
                            <label for="distrik" class="form-label">Distrik</label><br>
                            <input type="text" name="distrik" value="{{ $distrik->nama_distrik }}" class="form-control" readonly><br>
                        </div>
                        <div>
                            <label for="jKunjungan" class="form-label">Jenis Kunjungan</label><br>
                            <input id="IO" type="radio" name="jenis_kunjungan" value="IO" >IO
                            <input id="RO" type="radio" name="jenis_kunjungan" value="RO">RO
                            <input id="ROC" type="radio" name="jenis_kunjungan" value="ROC">ROC
                            <input id="R" type="radio" name="jenis_kunjungan" value="R">R
                            <input id="STA" type="radio" name="jenis_kunjungan" value="STA">STA <br>
                        </div>
                        <div class="nama-routing-div" style="display: none;">
                            <br><label for="inputRouting" class="form-label">Routing</label><br>
                            <select name="inputRouting" id="inputRouting" placeholder="routing" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select> <br>
                        </div>
                        <div class="nama-toko-div" style="display: none;">
                            <label for="nama_Toko" class="form-label">Nama Toko</label>
                            <input id="inputNamaToko" type="text" name="inputNamaToko" placeholder="Masukkan Nama Toko" class="form-control"><br>
                        </div>
                        <div class="pilih-nama-routing-div" style="display: none;">
                            <br><label for="routing" class="form-label">Routing</label><br>
                            <select name="routing" id="routing" placeholder="routing" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select> <br>
                        </div> 
                        <div class="pilih-nama-toko-div" style="display: none;">
                            <label for="pilih_nama_Toko" class="form-label">Nama Toko</label>
                            <select name="pilihNamaToko" id="pilihNamaToko" class="form-control">
                                <option value="">Pilih</option>
                            </select><br> 
                        </div>
                        <div>
                            <br><label for="b20" class="form-label">GROW BOLD 20</label>
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
                            <input type="number" name="produk[]" placeholder="KC" class="form-control" value="0"><br>
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
                        <div>
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input id="keterangan" type="text" name="keterangan" placeholder="keterangan" class="form-control"><br>
                        </div>
                        <div>
                            <label for="EMP" class="form-label">EMP</label><br>
                            <input id="sticker" type="checkbox" name="sticker" class="form-check-input">Sticker
                            <input id="plano" type="checkbox" name="plano" class="form-check-input">Plano
                            <input id="sunscreen" type="checkbox" name="sunscreen" class="form-check-input">Sunscreen
                        </div>
                        <div>
                            <br><label for="foto" class="form-label">Foto Toko</label>
                            <input type="file" name="foto" class="form-control"><br>
                        </div>
                        <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude" class="form-control"><br>
                        <input type="hidden" id="longitudeInput" name="longitude" placeholder="longitude" class="form-control"><br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
