@extends('layouts.gBesar')
@section('gBesar.body')
    <main>
        <h2>Daftar Request Gudang Kecil</h2>
        <div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal PO</th>
                        <th>Nomor PO</th>
                        <th>Deadline Pengiriman</th>
                        <th>Nama Requested</th>
                        <th>Catatan</th>
                        <th>Konfirmasi PimArea</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($daftarReq as $req)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $req->created_at }}</td>
                            <td>{{ $req->nomor_po }}</td>
                            <td>{{ $req->deadline_kirim }}</td>
                            <td>{{ $req->nama }}</td>
                            <td>{{ $req->catatan }}</td>
                            <td>
                                @if($req->konfirmasi == 0)
                                    <div class="alert alert-danger" style="width: fit-content;" role="alert">
                                        Belum
                                    </div>
                                @elseif($req->konfirmasi == 1)
                                    <div class="alert alert-info" style="width: fit-content;" role="alert">
                                        Sudah
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="request_gKecil/{{ $req->id }}/{{ $req->nomor_po }}" class="btn btn-primary">
                                    Detail
                                </a>
                            </td>
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
