@extends('layouts.karyawan')
@section('title')
    Absensi
@endsection
@section('karyawan.body')
    <main>
        <h2>Absensi</h2>
        <div class="card-body">
            <div class="mt-4">
                {{-- <a type="button" href="absen_keluar.php?id_absensi=" class="btn btn-danger">
                        Absen Keluar
                    </a> --}}
                <button type="button" class="btn btn-success focus-ring" data-bs-toggle="modal" data-bs-target="#absenMasuk">
                    <i class="fa-solid fa-right-to-bracket" style="color: #ffffff;"></i>
                    Absen Masuk
                </button>
                <button type="button" class="btn btn-danger focus-ring" data-bs-toggle="modal" data-bs-target="#absenMasuk"
                    style="margin-left: 1rem">
                    <i class="fa-solid fa-right-from-bracket" style="color: #ffffff;"></i>
                    Absen Keluar
                </button>
            </div>
            <div class="mt-4">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Id Pengguna</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>No Telepon</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th>Lokasi</th>
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
                        </tr>
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
                                    <form method="POST" class="myForm" enctype="multipart/form-data" action="">
                                        <div class="modal-body">
                                            <input type="file" name="foto" class="form-control" capture><br>
                                            <input type="text" name="keterangan" placeholder="keterangan"
                                                class="form-control" /><br>
                                            <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude"
                                                class="form-control" /><br>
                                            <input type="hidden" id="longitudeInput" name="longitude"
                                                placeholder="longitude" class="form-control" /><br>
                                            <!-- <input type="hidden" name="nama_karyawan" /> -->
                                            <button type="submit" class="btn btn-primary"
                                                name="addAbsenMasuk">Submit</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="absenKeluar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Absen Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="POST" class="myForm" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <input type="file" name="foto" class="form-control"><br>
                                            <input type="text" name="keterangan" placeholder="keterangan"
                                                class="form-control"><br>
                                            <input type="hidden" id="latitudeInput" name="latitude" placeholder="latitude"
                                                class="form-control"><br>
                                            <input type="hidden" id="longitudeInput" name="longitude"
                                                placeholder="longitude" class="form-control"><br>
                                            <button type="submit" class="btn btn-primary"
                                                name="addAbsenKeluar">Submit</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
