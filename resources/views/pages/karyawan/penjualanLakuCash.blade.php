@extends('layouts.karyawan')
@section('karyawan.body')
    <h2 class="mb-4 mt-4">Penjualan</h2>
    <div class="card mb-4 mt-4">
        <div class="card-header">
            @if (!$carryToday)
                <button class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="">
                    Penjualan
                </button>
                Ambil stok barang terlebih dahulu!
            @elseif($storToday)
                <div class="alert alert-info" style="width: fit-content;" role="alert">
                    Anda sudah melakukan stor hari ini!
                </div>
            @else
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalPenjualanLakuCash">
                    Penjualan
                </button>
            @endif
            <!-- Button trigger modal -->
            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenjualanLakuCash">
                Penjualan
            </button> --}}
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
                            <td>
                                @if ($plk->nama_foto)
                                    <img src="{{ asset('storage/' . $plk->nama_foto) }}" alt="Foto Absen"
                                        style="max-height: 350px; max-width: 200px; width: auto; height: auto;">
                                @else
                                    No Foto
                                @endif
                            </td>
                            <td>{{ $plk->latitude . ',' . $plk->longitude }}</td>
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
                {{-- @if (session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif --}}
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
                                    value="IO" required>
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
                                    @foreach ($routing as $rout)
                                        <option value="{{ $rout->id_routing }}">{{ $rout->nama_routing }}</option>
                                    @endforeach
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
                                <input type="text" class="form-control" id="namaToko" placeholder="Masukan Nama Toko"
                                    name="namaToko">
                            </div>
                        </div>
                        <div class="mb-3 d-none" id="notFormIO">
                            <div class="mb-3">
                                <label class="form-label">Routing</label>
                                <select class="form-select" id="routingDropdown" aria-label="Default select example"
                                    required name="routing">
                                    <option selected disabled>Pilih Routing</option>
                                    @foreach ($routing as $rout)
                                        <option value="{{ $rout->id_routing }}">{{ $rout->nama_routing }}</option>
                                    @endforeach
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
                        @if (!empty($totalCarryProduk))
                            @foreach ($totalCarryProduk as $dt)
                                <div>
                                    <label for="{{ $dt->id_produk }}" class="form-label">{{ $dt->nama_produk }}</label>
                                    <input min="0" value="0" type="number" id="{{ $dt->id_produk }}"
                                        name="jumlah[]" placeholder="{{ $dt->id_produk }}" class="form-control"><br>
                                    <input type="hidden" name="id_produk[]" value="{{ $dt->id_produk }}">
                                </div>
                            @endforeach
                        @else
                            <div>Data tidak ditemukan.</div>
                        @endif
                        <div>
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input id="keterangan" type="text" name="keterangan" placeholder="keterangan"
                                class="form-control" required><br>
                        </div>
                        <div>
                            {{-- <label class="form-label">EMP</label><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="stiker"
                                    id="stiker">
                                <label class="form-check-label" for="stiker">
                                    Stiker
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="plano"
                                    id="plano">
                                <label class="form-check-label" for="plano">
                                    Plano
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="emp[]" value="sunscreen"
                                    id="sunscreen">
                                <label class="form-check-label" for="sunscreen">
                                    Sunscreen
                                </label>
                            </div> --}}
                            <label class="form-label">EMP</label><br>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" id="stiker">
                                    <label for="stiker" class="ms-1">Stiker</label>
                                </div>
                                <input type="number" class="form-control" aria-label="Text input with checkbox"
                                    id="stikerInput" disabled name="jumlahEmp[]">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" id="plano">
                                    <label for="plano" class="ms-1">Plano</label>
                                </div>
                                <input type="number" class="form-control" aria-label="Text input with checkbox"
                                    id="planoInput" disabled name="jumlahEmp[]">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" value=""
                                        aria-label="Checkbox for following text input" id="sunscreen">
                                    <label for="sunscreen" class="ms-1">Sunscreen</label>
                                </div>
                                <input type="number" class="form-control" aria-label="Text input with checkbox"
                                    id="sunscreenInput" disabled name="jumlahEmp[]">
                            </div>
                            {{-- <div class="form-check">
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
                            </div>                             --}}
                        </div>
                        <div>
                            <br><label for="foto" class="form-label">Foto Toko</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control @error('foto') is-invalid @enderror" required><br>
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude"
                            class="form-control"><br>
                        <input type="hidden" id="longitudeInput" name="longitude" placeholder="longitude"
                            class="form-control"><br>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Handle the change event of the first dropdown
            $("#routingDropdown").change(function() {
                var selectedOption = $(this).val();
                console.log(selectedOption)
                // Clear the options in the second dropdown
                $("#tokoDropdown").empty();
                $("#tokoDropdown").append('<option value="" disabled selected>Pilih Toko</option>');

                // Fetch the dependent options for the selected option
                $.ajax({
                    url: "/user/get_routing/" + selectedOption,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $("#tokoDropdown").append(
                                $("<option></option>")
                                .attr("value", value.id_toko)
                                .text(value.nama_toko)
                            );
                        });
                    },
                });
            });

            $("#tokoDropdown").change(function() {
                let val = $(this).val()
                console.log(val)
            })

            // emp input
            $('#stiker').change(function() {
                if ($(this).is(':checked')) {
                    // Checkbox is checked
                    $('#stikerInput').prop('disabled', false);
                    $('#stikerInput').val('0');
                    // Perform your desired actions here
                } else {
                    // Checkbox is unchecked
                    $('#stikerInput').prop('disabled', true);
                    $('#stikerInput').val('');
                    // Perform your desired actions here
                }
            });
            $('#plano').change(function() {
                if ($(this).is(':checked')) {
                    // Checkbox is checked
                    $('#planoInput').prop('disabled', false);
                    $('#planoInput').val('0');
                    // Perform your desired actions here
                } else {
                    // Checkbox is unchecked
                    $('#planoInput').prop('disabled', true);
                    $('#planoInput').val('');
                    // Perform your desired actions here
                }
            });
            $('#sunscreen').change(function() {
                if ($(this).is(':checked')) {
                    // Checkbox is checked
                    $('#sunscreenInput').prop('disabled', false);
                    $('#sunscreenInput').val('0');
                    // Perform your desired actions here
                } else {
                    // Checkbox is unchecked
                    $('#sunscreenInput').prop('disabled', true);
                    $('#sunscreenInput').val('');
                    // Perform your desired actions here
                }
            });
        });
    </script>
@endsection
