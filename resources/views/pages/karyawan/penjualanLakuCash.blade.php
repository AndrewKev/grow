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
                        <th>Routing</th>
                        <th>Nama Toko</th>
                        <th>Keterangan</th>
                        <th>Emp</th>
                        <th>Foto</th>
                        <th>GeoLocation</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php
                        dd($penjualanLk);
                    @endphp --}}
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($penjualanLk as $plk)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $plk->created_at }}</td>
                            <td>{{ $plk->nama_routing }}</td>
                            <td><a href="penjualan_laku_cash/{{ $plk->id_toko }}">{{ $plk->nama_toko }}</a></td>
                            <td>{{ $plk->keterangan }}</td>
                            <td>{{ $plk->emp }}</td>
                            <td></td>
                            <td>{{ $plk->latitude.','.$plk->longitude}}</td>
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
    <div class="modal fade" id="modalPenjualanLakuCash" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/user/penjualan_laku_cash" method="post" class="myForm" enctype="multipart/form-data"
                    id="formToko">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="distrik" class="form-label">Distrik</label>
                            <input type="text" name="distrik" value="{{ $distrik[0]->nama_distrik }}"
                                class="form-control" readonly>
                            <input type="hidden" name="id_distrik" value="{{ $distrik[0]->id_distrik }}">
                        </div>
                        <div class="mb-3">
                            <label for="jKunjungan" class="form-label">Jenis Kunjungan</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="IO"
                                    value="IO">
                                <label class="form-check-label" for="IO">IO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="RO"
                                    value="RO">
                                <label class="form-check-label" for="RO">RO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="ROC"
                                    value="ROC">
                                <label class="form-check-label" for="ROC">ROC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="R"
                                    value="R">
                                <label class="form-check-label" for="R">R</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="STA"
                                    value="STA">
                                <label class="form-check-label" for="STA">STA</label>
                            </div>
                        </div>
                        <div class="mb-3 d-none" id="formIO">
                            <div class="mb-3">
                                <label class="form-label">Routing</label>
                                <select class="form-select" aria-label="Default select example" required name="routing">
                                    <option selected disabled>Pilih Routing</option>
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
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="namaToko" class="form-label">Nama Toko</label>
                                <input type="text" class="form-control" id="namaToko" placeholder="Masukan Nama Toko" name="namaToko">
                            </div>
                        </div>
                        <div class="mb-3 d-none" id="notFormIO">
                            <div class="mb-3">
                                <label class="form-label">Routing</label>
                                <select class="form-select" aria-label="Default select example" required name="routing">
                                    <option selected disabled>Pilih Routing</option>
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
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="namaToko" class="form-label">Nama Toko</label>
                                <select class="form-select" aria-label="Default select example" required name="routing">
                                    <option selected disabled>Pilih Routing</option>
                                    <option value="namaToko" name="namaToko">namaToko</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="b20" class="form-label">GROW BOLD 20</label>
                            <input type="number" id="B20" name="produk[]" placeholder="B20" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B20">
                        </div>
                        <div>
                            <label for="b16" class="form-label">GROW BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="B16" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B16">
                        </div>
                        <div>
                            <label for="b12" class="form-label">GROW BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="B12" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B12">
                        </div>
                        <div>
                            <label for="r16" class="form-label">GROW REG 16</label>
                            <input type="number" name="produk[]" placeholder="R16" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="R16">
                        </div>
                        <div>
                            <label for="r12" class="form-label">GROW REG 12</label>
                            <input type="number" name="produk[]" placeholder="R12" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="R12">
                        </div>
                        <div>
                            <label for="kk" class="form-label">GROW KRETEK KUNING 12</label>
                            <input type="number" name="produk[]" placeholder="KK" class="form-control"
                                value="0"><br>
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
                        <div>
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input id="keterangan" type="text" name="keterangan" placeholder="keterangan"
                                class="form-control"><br>
                        </div>
                        <div>
                            <label class="form-label">EMP</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="stiker" id="stiker">
                                <label class="form-check-label" for="stiker">
                                    Stiker
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="plano" id="plano">
                                <label class="form-check-label" for="plano">
                                    Plane
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="sunscreen" id="sunscreen">
                                <label class="form-check-label" for="sunscreen">
                                    Sunscreen
                                </label>
                            </div>
                        </div>
                        <div>
                            <br><label for="foto" class="form-label">Foto Toko</label>
                            <input type="file" name="foto" class="form-control"><br>
                        </div>
                        <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude"
                            class="form-control"><br>
                        <input type="hidden" id="longitudeInput" name="longitude" placeholder="longitude"
                            class="form-control"><br>
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
