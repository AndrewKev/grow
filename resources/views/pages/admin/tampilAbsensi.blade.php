@extends('layouts.admin')
@section('admin.body')
    <main>
        <h2>Daftar Absensi</h2>
        <div class="card-body">
            <div class="mt-4">
            </div>
            <div class="mt-4">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            {{-- <th>Jabatan</th> --}}
                            <th>No Telepon</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Keterangan</th>
                            {{-- <th>Foto</th> --}}
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($listAbsenUser as $absen)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $absen->nama }}</td>
                                <td>{{ $absen->no_telp }}</td>
                                <td>{{ $absen->waktu_masuk }}</td>
                                <td>{{ $absen->waktu_keluar }}</td>
                                <td>{{ $absen->keterangan }}</td>
                                <td>{{ $absen->latitude }},{{ $absen->longitude }}</td>
                            </tr>
                                @php
                                $no++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
