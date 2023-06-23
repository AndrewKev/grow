@extends('layouts.spo')
@section('spo.body')
    <h2 class="mb-4 mt-4">Penjualan</h2>
    <div class="card mb-4 mt-4">
        <div class="card-header">
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>          
                            </td>
                            <td></td>
                        </tr>
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
                {{-- @if (session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif --}}
                <form action="/user/penjualan_laku_cash" method="post" class="myForm" enctype="multipart/form-data"
                    id="formToko">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="distrik" class="form-label">Distrik</label>
                            {{-- <input type="text" name="distrik" value="{{ $distrik[0]->nama_distrik }}"
                                class="form-control" readonly>
                            <input type="hidden" name="id_distrik" value="{{ $distrik[0]->id_distrik }}"> --}}
                        </div>
                        <div class="mb-3">
                            <label for="jKunjungan" class="form-label">Jenis Kunjungan</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="NEW"
                                    value="NEW" required>
                                <label class="form-check-label" for="NEW">SPO NEW</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="CLOSE"
                                    value="CLOSE">
                                <label class="form-check-label" for="CLOSE">SPO CLOSE</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="CASH"
                                    value="CASH">
                                <label class="form-check-label" for="CASH">CASH</label>
                            </div>
                            {{-- <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="R"
                                    value="R">
                                <label class="form-check-label" for="R">R</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kunjungan" id="STA"
                                    value="STA">
                                <label class="form-check-label" for="STA">STA</label>
                            </div> --}}
                        </div>
                        <div class="mb-3 d-none" id="formIO">
                            <div class="mb-3">
                                <label class="form-label">Routing</label>
                                <select class="form-select" aria-label="Default select example" required name="routing">
                                    <option selected disabled>Pilih Routing</option>
                                    {{-- @foreach ($routing as $rout)
                                        <option value="{{ $rout->id_routing }}">{{ $rout->nama_routing }}</option>
                                    @endforeach --}}
                                    {{-- <option value="1">1</option>
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
                                    <option value="12">12</option> --}}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="namaToko" class="form-label">Nama Toko</label>
                                <input type="text" class="form-control" id="namaToko"
                                    placeholder="Masukan Nama Toko" name="namaToko">
                            </div>
                        </div>
                        <div class="mb-3 d-none" id="notFormIO">
                            <div class="mb-3">
                                <label class="form-label">Routing</label>
                                <select class="form-select" id="routingDropdown" aria-label="Default select example"
                                    required name="routing">
                                    <option selected disabled>Pilih Routing</option>
                                    {{-- @foreach ($routing as $rout)
                                        <option value="{{ $rout->id_routing }}">{{ $rout->nama_routing }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="namaToko" class="form-label">Nama Toko</label>
                                <select class="form-select" id="tokoDropdown" aria-label="Default select example"
                                    required name="toko">
                                    <option selected disabled>Pilih Toko</option>
                                    {{-- <option value="namaToko" name="namaToko">namaToko</option> --}}
                                </select>
                            </div>
                        </div>
                        {{-- @if (!empty($totalCarryProduk))
                            @foreach ($totalCarryProduk as $dt)
                                    <div>
                                        <label for="{{ $dt->id_produk }}" class="form-label">{{ $dt->nama_produk }}</label>
                                        <input min="0" value="0" type="number" id="{{ $dt->id_produk }}" name="jumlah[]"
                                            placeholder="{{ $dt->id_produk }}" class="form-control"><br>
                                        <input type="hidden" name="id_produk[]" value="{{ $dt->id_produk }}">
                                    </div>
                            @endforeach
                        @else
                            <!-- Tampilkan pesan jika tidak ada data -->
                            <div>Data tidak ditemukan.</div>
                        @endif --}}
                        <div>
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input id="keterangan" type="text" name="keterangan" placeholder="keterangan"
                                class="form-control" required><br>
                        </div>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="stiker" id="stiker">
                                <label class="form-check-label" for="stiker">
                                    Stiker
                                </label>
                                <input type="number" id="jumlahStiker" name="jumlahEmp[]" value="0" class="form-control">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="plano" id="plano">
                                <label class="form-check-label" for="plano">
                                    Plano
                                </label>
                                <input type="number" id="jumlahPlano" name="jumlahEmp[]" value="0" class="form-control">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="sunscreen" id="sunscreen">
                                <label class="form-check-label" for="sunscreen">
                                    Sunscreen
                                </label>
                                <input type="number" id="jumlahSunscreen" name="jumlahEmp[]" value="0" class="form-control">
                            </div>                            
                        </div>
                        <div>
                            <br><label for="foto" class="form-label">Foto Toko</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" required
                            ><br>
                            {{-- @error('foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror                  --}}
                        </div>
                        <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude"
                            class="form-control"><br>
                        <input type="hidden" id="longitudeInput" name="longitude" placeholder="longitude"
                            class="form-control"><br>
                            {{-- @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif --}}
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <script src="{{ asset('js/custom.js') }}"></script>

@endsection
