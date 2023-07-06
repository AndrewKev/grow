@extends('layouts.spo')
@section('spo.body')
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h2 class="mb-4 mt-4">Daftar SPO Closed</h2>
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
                    @foreach ($tokoClosedSpo as $item)
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
                                @if ($item->get('is_close') == 0)
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
                            $no++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
