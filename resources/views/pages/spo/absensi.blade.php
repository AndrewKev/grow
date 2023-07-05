@extends('layouts.spo')
@section('title')
    Absensi
@endsection
@section('spo.body')
    <main>
        <h2>Absensi</h2>
        <div class="card-body">
            <div class="mt-4">
                @if (sizeof($listAbsenUser) != 0 && $listAbsenUser[0]->waktu_keluar == null)
                    @if (!$finishStor)
                        <button class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="">
                            <i class="fa-solid fa-right-from-bracket" style="color: #4f4f4f;"></i>
                            Absen Keluar
                        </button>
                    @else
                        <form onsubmit="return confirm('Konfirmasi Absen Keluar')" action="/spo/absensi_keluar" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger focus-ring">
                                <i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i>
                                Absen Keluar
                            </button>
                        </form>
                    @endif
                @else
                    @if ($isAbsensi)
                        <button class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="">
                            <i class="fa-solid fa-right-to-bracket" style="color: #4f4f4f;"></i>
                            Absen Masuk
                        </button>
                    @else
                        <button type="button" class="btn btn-success focus-ring" data-bs-toggle="modal"
                            data-bs-target="#absenMasuk">
                            <i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i>
                            Absen Masuk
                        </button>
                    @endif
                @endif
            </div>
            <div class="mt-4">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            {{-- <th>Jabatan</th> --}}
                            <th>No Telepon</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Foto</th>
                            <th>Keterangan</th>
                            {{-- <th>Foto</th> --}}
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listAbsenUser as $list)
                            <tr>
                                <td>{{ $list->nama }}</td>
                                <td>{{ $list->no_telp }}</td>
                                <td>{{ $list->waktu_masuk }}</td>
                                <td>{{ $list->waktu_keluar == null ? '-' : $list->waktu_keluar }}</td>
                                <td>
                                    @if ($list->foto)
                                        <img src="{{ asset('storage/' . $list->foto) }}" alt="Foto Absen"
                                            style="max-height: 350px; max-width: 200px; width: auto; height: auto;">
                                    @else
                                        No Foto
                                    @endif
                                </td>
                                <td>{{ $list->keterangan }}</td>
                                <td>{{ $list->latitude }}, {{ $list->longitude }}</td>
                            </tr>
                        @endforeach
                        <!-- Modal -->
                        <div class="modal fade" id="absenMasuk" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Absen Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="/spo/absensi" class="myForm" id="formAbsenMasuk" enctype="multipart/form-data"
                                        action="">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="file" id="foto" name="foto"
                                                class="form-control  @error('foto') is-invalid @enderror" capture
                                                required><br>
                                            @error('foto')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="text" name="keterangan" placeholder="keterangan"
                                                class="form-control" /><br>
                                            <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude"
                                                class="form-control" /><br>
                                            <input type="hidden" id="longitudeInput" name="longitude"
                                                placeholder="longitude" class="form-control" /><br>
                                            <button type="submit" class="btn btn-primary" name="addAbsenMasuk"
                                                id="btnSubmit">Submit</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            if($('#foto').get(0).files.length === 0) {
                $('#btnSubmit').prop('disabled', true);
            }
            $('#foto').change(function() {
                // if($(this).get(0).files[0]) {
                //     $('#btnSubmit').prop('disabled', true);
                // } else {
                    $('#btnSubmit').prop('disabled', false);
                // }
            });
            $('#btnSubmit').click(function() {
                // event.preventDefault();
                $(this).prop('disabled', true);
                $('#formAbsenMasuk').submit();
            });
        });
    </script>
@endsection
