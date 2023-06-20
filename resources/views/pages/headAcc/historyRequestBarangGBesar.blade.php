@extends('layouts.headAcc')
@section('headAcc.body')
    <main>
        <h2>History Request Gudang Besar</h2>
        <div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Gudang</th>
                        <th>Tanggal PO</th>
                        <th>Deadline Kirim</th>
                        <th>Konfirm PimArea</th>
                        <th>Konfirm GBesar</th>
                        <th>Catatan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($historyRequestGBesar as $his)
                   <tr>
                        <th>{{ $no }}</th>
                        <th>{{ $his->tanggal }}</th>
                        <th>{{ $his->nama_admin }}</th>
                        <th>{{ $his->tanggal_po }}</th>
                        <th>{{ $his->deadline_kirim }}</th>
                        <th>@if($his->konfirmasi == 0)
                            <div class="alert alert-danger" style="width: fit-content;" role="alert">
                                Belum
                            </div>
                        @elseif($his->konfirmasi == 1)
                            <div class="alert alert-info" style="width: fit-content;" role="alert">
                                {{ $his->tanggal_konfirm }}
                            </div>
                        @endif</th>
                        <th>@if($his->konfirmasi2 == 0)
                            <div class="alert alert-danger" style="width: fit-content;" role="alert">
                                Belum
                            </div>
                        @elseif($his->konfirmasi2 == 1)
                            <div class="alert alert-info" style="width: fit-content;" role="alert">
                                {{ $his->tanggal_konfirm2 }}
                            </div>
                        @endif</th>
                        <th>{{ $his->catatan }}</th>
                        <th><a href="history_request_barang_gBesar/{{ $his->keterangan }}/{{ $his->nama_admin }}/{{ $his->tanggal }}">{{ $his->keterangan }}</a></th>
                   </tr>
                        @php
                            $no++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection
