@extends('layouts.spo')
@section('spo.body')
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenjualan">
                    Penjualan
                </button>
            @endif
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Distrik</th>
                        <th>Nama Toko</th>
                        <th>Nomor Nota</th>
                        <th>Jenis Spo</th>
                        <th>Keterangan</th>
                        <th>Emp</th>
                        <th>Foto</th>
                        <th>GeoLocation</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($getPenjualanSPO as $item)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->id_distrik }}</td>
                        <td><a href="penjualan_spo/{{ $item->id }}">{{ $item->nama_toko }}</a></td>
                        <td>{{ $item->nomor_spo }}</td>
                        <td>{{ $item->jenis_spo }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->emp }}</td>
                        <td>
                            @if ($item->nama_foto)
                                <img src="{{ asset('storage/' . $item->nama_foto) }}" alt="Foto SPO"
                                    style="max-height: 350px; max-width: 200px; width: auto; height: auto;">
                            @else
                                No Foto
                            @endif
                        </td>
                        <td>{{ $item->latitude . ',' . $item->longitude }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalPenjualan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/spo/penjualan_spo" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Penjualan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="distrik" class="form-label">Distrik</label>
                        <select class="form-select" aria-label="Default select example" id="dropdownDistrik" name="distrik_spo">
                            <option selected disabled>Pilih Distrik</option>
                            {{-- <option value=""></option> --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Toko</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisToko" value="TokoBaru" id="radioTokoBaru"
                                value="tokoBaru">
                            <label class="form-check-label" for="radioTokoBaru">Toko Baru</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisToko" value="TokoLama" id="radioTokoLama"
                                value="tokoLama">
                            <label class="form-check-label" for="radioTokoLama">Toko Lama</label>
                        </div>
                    </div>
                    <div class="mb-3 d-none" id="inputTokoBaru">
                        <label for="namaToko" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" name = "inputTokoBaru" id="namaToko" placeholder="Masukan Nama Toko" required>
                    </div>
                    <div class="mb-3 d-none" id="inputTokoLama">
                        <label class="form-label">Nama Toko</label>
                        <select class="form-select" aria-label="Default select example" name = "inputTokoLama" id="dropdownToko">
                            <option selected disabled>Pilih Toko</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="divAlamat">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat_spo" placeholder="Masukan Alamat" required>
                    </div>
                    <div class="mb-3 d-none" id="divTelepon">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukan No Telepon"
                            value="-" required>
                        <input type="hidden" id="wsCode" name="wsCode">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis SPO</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisSpo" id="inlineRadioSpo1"
                                value="spoNew">
                            <label class="form-check-label" for="inlineRadio1">SPO New</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisSpo" id="inlineRadioSpo2"
                                value="spoClose">
                            <label class="form-check-label" for="inlineRadio2">SPO Close</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisSpo" id="inlineRadioSpo3"
                                value="spoCash">
                            <label class="form-check-label" for="inlineRadio2">Cash</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="noNota" class="form-label">Nomor Nota</label>
                        <input type="text" class="form-control" id="noNota" placeholder="" name="nomor_nota" value="-"
                            readonly>
                    </div>
                    @if (!empty($totalCarryProduk))
                        @foreach ($totalCarryProduk as $dt)
                            <div class="mb-3">
                                <label for="{{ $dt['idProduk'] }}" class="form-label">{{ $dt['namaProduk'] }}</label>
                                <input min="0" value="0" type="number" id="_{{ $dt['idProduk'] }}"
                                    name="jumlah[]" placeholder="{{ $dt['idProduk'] }}" class="form-control">
                                <div>
                                    <span class="text-success">Stok produk ini : {{ $dt['stokSekarang'] }}</span>
                                </div>
                                <div class="d-none" id="valid_{{ $dt['idProduk'] }}">
                                    <span class="text-danger">Stok tidak cukup</span>
                                </div>
                                <input type="hidden" data-input-id="stok{{ $dt['idProduk'] }}"
                                    value="{{ $dt['stokSekarang'] }}">
                                <input type="hidden" name="id_produk[]" value="{{ $dt['idProduk'] }}">
                            </div>
                        @endforeach
                    @else
                        <div>Data tidak ditemukan.</div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">EMP</label><br>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="stiker"
                                    aria-label="Checkbox for following text input" id="stiker">
                                <label for="stiker" class="ms-1">Stiker</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="stikerInput" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="plano"
                                    aria-label="Checkbox for following text input" id="plano">
                                <label for="plano" class="ms-1">Plano</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="planoInput" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="sunscreen"
                                    aria-label="Checkbox for following text input" id="sunscreen">
                                <label for="sunscreen" class="ms-1">Sunscreen</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="sunscreenInput" name="jumlahEmp[]" disabled>
                        </div>
                    </div>
                    <div>
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input id="keterangan" type="text" name="keterangan" placeholder="Masukan Keterangan"
                            class="form-control" required>
                    </div>
                    <div>
                        <br><label for="foto" class="form-label">Foto Toko</label>
                        <input type="file" name="foto" id="foto"
                            class="form-control @error('foto') is-invalid @enderror" required>
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
    <script>
        $(document).ready(function() {
            let distrik = '';
            let noNota = '';
            let wsCode = '000';
            // Dropdown
            // Populate the first dropdown
            $.ajax({
                url: "get_distrik",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, value) {
                        $("#dropdownDistrik").append(
                            $("<option></option>")
                            .attr("value", value.id_distrik)
                            .text(value.nama_distrik)
                        );
                    });
                },
            });

            // Handle the change event of the first dropdown
            $("#dropdownDistrik").change(function() {
                let selectedOption = $(this).val();
                distrik = selectedOption;

                // Clear the options in the second dropdown
                $("#dropdownToko").empty();
                $("#dropdownToko").append('<option selected disabled>Pilih Toko</option>');
                $('#radioTokoBaru').prop('checked', false);

                noNota = `JOG/${distrik}/000/000`;
                $('#noNota').val(noNota);

                // Fetch the dependent options for the selected option
                $.ajax({
                    url: "get_toko/" + selectedOption,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $("#dropdownToko").append(
                                $("<option></option>")
                                .attr("value", value.id)
                                .text(value.nama_toko)
                            );
                            // $('#alamat').val(value.nama_toko);
                        });
                    },
                });
            });

            $("#dropdownToko").on('change', function() {
                let idToko = $(this).val();

                // Fetch the dependent options for the selected option
                $.ajax({
                    url: "get_alamat/" + idToko,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#alamat').val(value.alamat);
                            $('#telepon').val(value.telepon);
                            wsCode = value.ws;
                            // wsCode = $('#wsCode').val(value.ws);
                            noNota = `JOG/${distrik}/${wsCode}/${value.aktivasi}`;
                            $('#noNota').val(noNota);
                        });
                    },
                });

                // wsCode = $('#wsCode').val();
                // $('#wsCode').on('input', function() {
                // })
            });
            // End Dropdown

            //produk input
            // $(document).ready(function() {
            $('input[name="jumlah[]"]').on('input', function() {
                var productId = $(this).attr('id').replace('_', '');
                var inputVal = $(this).val();
                var stokVal = $('input[data-input-id="stok' + productId + '"]').val();
                var $validDiv = $('#valid_' + productId);

                if (parseInt(inputVal) > parseInt(stokVal)) {
                    $('#submitButton').prop('disabled', true);
                    $validDiv.removeClass('d-none');
                } else {
                    $('#submitButton').prop('disabled', false);
                    $validDiv.addClass('d-none');
                }
            });
            // });

            $('#radioTokoBaru').change(function() {
                let lastWs = '000';
                if ($(this).is(':checked')) {
                    $('#inputTokoBaru').removeClass('d-none');
                    $('#inputTokoLama').addClass('d-none');
                    $('#divAlamat').removeClass('d-none');
                    $('#divTelepon').removeClass('d-none');
                    $('#alamat').val('');
                    $('#telepon').val('');

                    $.ajax({
                        url: "get_last_ws/" + distrik,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            lastWs = data;
                            noNota = `JOG/${distrik}/${lastWs}/001`;
                            $('#noNota').val(noNota);
                        },
                    });

                }
            });
            $('#radioTokoLama').change(function() {
                if ($(this).is(':checked')) {
                    $('#inputTokoBaru').addClass('d-none');
                    $('#inputTokoLama').removeClass('d-none');
                    $('#divAlamat').removeClass('d-none');
                    $('#divTelepon').removeClass('d-none');
                }
            });
            // Event handler for checkbox change event
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

        // document.getElementById("dropdownDistrik").addEventListener("change", function() {
        //     var selectedDistrik = this.value;

        //     // Mengubah nilai kedua pada nomor nota sesuai dengan distrik yang dipilih
        //     var noNotaElement = document.getElementById("noNota");
        //     var noNotaValue = "JOG/" + selectedDistrik + "/001/001";
        //     noNotaElement.value = noNotaValue;
        // });
    </script>
@endsection
