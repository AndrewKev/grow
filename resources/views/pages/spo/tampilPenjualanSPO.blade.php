@extends('layouts.spo')
@section('spo.body')
    <h2 class="mb-4 mt-4">Penjualan</h2>
    <div class="card mb-4 mt-4">
        <div class="card-header">
            {{-- @if (!$carryToday)
                <button class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="">
                    Penjualan
                </button>
                Ambil stok barang terlebih dahulu!
            @elseif($storToday)
                <div class="alert alert-info" style="width: fit-content;" role="alert">
                    Anda sudah melakukan stor hari ini!
                </div>
            @else --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenjualan">
                Penjualan
            </button>
            {{-- @endif --}}
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Distrik</th>
                        <th>Nomor Nota</th>
                        <th>Jenis Spo</th>
                        <th>Tanggal Penjualan</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Keterangan</th>
                        <th>Emp</th>
                        <th>Foto</th>
                        <th>GeoLocation</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($getPenjualanSPO as $item)
                        <tr>
                            <td>{{ $no }}</td>
                            <td><a href="penjualan_spo/{{ $item->get('id_toko') }}">{{ $item->get('nama_toko') }}</a></td>
                            <td>{{ $item->get('id_distrik') }}</td>
                            <td>{{ $item->get('nomor_spo') }}</td>
                            <td>{{ $item->get('jenis_spo') }}</td>
                            <td>{{ $item->get('tanggal_masuk') }}</td>
                            <td>{{ $item->get('tanggal_jatuh_tempo') }}</td>
                            <td>{{ $item->get('keterangan') }}</td>
                            <td>{{ $item->get('emp') }}</td>
                            <td>
                                @if ($item->get('nama_foto'))
                                    <img src="{{ asset('storage/' . $item->get('nama_foto')) }}" alt="Foto SPO"
                                        style="max-height: 350px; max-width: 200px; width: auto; height: auto;">
                                @else
                                    No Foto
                                @endif
                            </td>
                            <td>{{ $item->get('latitude') . ',' . $item->get('longitude') }}</td>
                            <td>
                                @if ($item->get('isClose') == 0)
                                    <div class="alert alert-success d-flex flex-column" role="alert">
                                        SPO Berjalan
                                        <span class="fw-bold">
                                            Sisa : {{ $item->get('sisa_jatuh_tempo') }} hari lagi
                                        </span>
                                    </div>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        SPO Close
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @php
                            $no++
                        @endphp
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
                        <select class="form-select" aria-label="Default select example" id="dropdownDistrik"
                            name="distrik_spo">
                            <option selected disabled>Pilih Distrik</option>
                            {{-- <option value=""></option> --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Toko</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisToko" value="TokoBaru"
                                id="radioTokoBaru" value="tokoBaru">
                            <label class="form-check-label" for="radioTokoBaru">Toko Baru</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisToko" value="TokoLama"
                                id="radioTokoLama" value="tokoLama">
                            <label class="form-check-label" for="radioTokoLama">Toko Lama</label>
                        </div>
                    </div>
                    <div class="mb-3 d-none" id="inputTokoBaru">
                        <label for="namaToko" class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" name="inputTokoBaru" id="namaToko"
                            placeholder="Masukan Nama Toko" required>
                    </div>
                    <div class="mb-3 d-none" id="inputTokoLama">
                        <label class="form-label">Nama Toko</label>
                        <select class="form-select" aria-label="Default select example" name="inputTokoLama"
                            id="dropdownToko">
                            <option id="initToko" selected disabled>Pilih Toko</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="divAlamat">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat_spo"
                            placeholder="Masukan Alamat" required>
                    </div>
                    <div class="mb-3 d-none" id="divTelepon">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon"
                            placeholder="Masukan No Telepon" value="-" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis SPO</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisSpo" id="inlineRadioSpo1"
                                value="spoNew">
                            <label class="form-check-label" for="inlineRadio1">SPO New</label>
                        </div>
                        {{-- <div class="form-check form-check-inline spo-close">
                            <input class="form-check-input" type="radio" name="jenisSpo" id="inlineRadioSpo2"
                                value="spoClose">
                            <label class="form-check-label" for="inlineRadio2">SPO Close</label>
                        </div> --}}
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenisSpo" id="inlineRadioSpo3"
                                value="spoCash">
                            <label class="form-check-label" for="inlineRadio2">Cash</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="noNota" class="form-label">Nomor Nota</label>
                        <input type="text" class="form-control" id="noNota" placeholder="" name="nomor_nota"
                            value="-" readonly>
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
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="gelas230ml"
                                    aria-label="Checkbox for following text input" id="gelas230ml">
                                <label for="gelas230ml" class="ms-1">Gelas 230ml</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="gelas230Input" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="gelas400ml"
                                    aria-label="Checkbox for following text input" id="gelas400ml">
                                <label for="gelas400ml" class="ms-1">Gelas 400ml</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="gelas400Input" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="tumblr"
                                    aria-label="Checkbox for following text input" id="tumblr">
                                <label for="tumblr" class="ms-1">Tumblr</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="tumblrInput" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="kaos"
                                    aria-label="Checkbox for following text input" id="kaos">
                                <label for="kaos" class="ms-1">Kaos</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="kaosInput" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="kalender"
                                    aria-label="Checkbox for following text input" id="kalender">
                                <label for="kalender" class="ms-1">Kalender</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="kalenderInput" name="jumlahEmp[]" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" name="emp[]" value="lighter"
                                    aria-label="Checkbox for following text input" id="lighter">
                                <label for="lighter" class="ms-1">Lighter</label>
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox"
                                id="lighterInput" name="jumlahEmp[]" disabled>
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
                    <input type="hidden" id="wsCode" name="wsCode">
                    <input type="hidden" id="nomorAktivasi" name="nomorAktivasi">
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
                $("#dropdownToko").append('<option id="initToko" selected disabled>Pilih Toko</option>');
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
                            if (value.isClose == 0) {
                                $('#inlineRadioSpo1').prop('disabled', true);
                                $('label[for="inlineRadio1"]').html(
                                    'SPO New (silahkan close terlebih dahulu)');
                            }
                            $('#alamat').val(value.alamat);
                            $('#telepon').val(value.telepon ? value.telepon : '-');
                            $('#wsCode').val(value.ws);
                            $('#nomorAktivasi').val(value.aktivasi);
                            wsCode = value.ws;
                            noNota = `JOG/${distrik}/${wsCode}/${value.aktivasi}`;
                            $('#noNota').val(noNota);
                        });
                    },
                });
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
                    $('#inlineRadioSpo1').prop('disabled', false);
                    $('label[for="inlineRadio1"]').html('SPO New');
                    $('#inputTokoBaru').removeClass('d-none');
                    $('#inputTokoLama').addClass('d-none');
                    // $('.spo-close').addClass('d-none');
                    $('#divAlamat').removeClass('d-none');
                    $('#divTelepon').removeClass('d-none');
                    $('#alamat').val('');
                    $('#telepon').val('');
                    $('#namaToko').attr('required', 'required');

                    $.ajax({
                        url: "get_last_ws/" + distrik,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            lastWs = data;
                            noNota = `JOG/${distrik}/${lastWs}/001`;
                            $('#wsCode').val(lastWs);
                            $('#noNota').val(noNota);
                            $('#nomorAktivasi').val('001');
                        },
                    });

                }
            });
            $('#radioTokoLama').change(function() {
                if ($(this).is(':checked')) {
                    $('#initToko').prop('selected', true);
                    $('#inputTokoBaru').addClass('d-none');
                    $('#namaToko').removeAttr('required');
                    // $('#inputTokoBaru').prop('disabled', true);
                    $('#inputTokoLama').removeClass('d-none');
                    $('#divAlamat').removeClass('d-none');
                    $('#divTelepon').removeClass('d-none');
                    // $('.spo-close').removeClass('d-none');
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
            $('#gelas230ml').change(function() {
                if ($(this).is(':checked')) {
                    $('#gelas230Input').prop('disabled', false);
                    $('#gelas230Input').val('0');
                } else {
                    $('#gelas230Input').prop('disabled', true);
                    $('#gelas230Input').val('');
                }
            });
            $('#gelas400ml').change(function() {
                if ($(this).is(':checked')) {
                    $('#gelas400Input').prop('disabled', false);
                    $('#gelas400Input').val('0');
                } else {
                    $('#gelas400Input').prop('disabled', true);
                    $('#gelas400Input').val('');
                }
            });
            $('#tumblr').change(function() {
                if ($(this).is(':checked')) {
                    $('#tumblrInput').prop('disabled', false);
                    $('#tumblrInput').val('0');
                } else {
                    $('#tumblrInput').prop('disabled', true);
                    $('#tumblrInput').val('');
                }
            });
            $('#kaos').change(function() {
                if ($(this).is(':checked')) {
                    $('#kaosInput').prop('disabled', false);
                    $('#kaosInput').val('0');
                } else {
                    $('#kaosInput').prop('disabled', true);
                    $('#kaosInput').val('');
                }
            });
            $('#kalender').change(function() {
                if ($(this).is(':checked')) {
                    $('#kalenderInput').prop('disabled', false);
                    $('#kalenderInput').val('0');
                } else {
                    $('#kalenderInput').prop('disabled', true);
                    $('#kalenderInput').val('');
                }
            });
            $('#lighter').change(function() {
                if ($(this).is(':checked')) {
                    $('#lighterInput').prop('disabled', false);
                    $('#lighterInput').val('0');
                } else {
                    $('#lighterInput').prop('disabled', true);
                    $('#lighterInput').val('');
                }
            });
        });
    </script>
@endsection
