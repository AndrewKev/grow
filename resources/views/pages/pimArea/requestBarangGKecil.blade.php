@extends('layouts.pimArea')
@section('pimArea.body')
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($daftarReq as $dr)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $dr->tanggal_po }}</td>
                            <td>{{ $dr->nomor_po }}</td>
                            <td>{{ $dr->deadline_kirim }}</td>
                            <td>{{ $dr->nama }}</td>
                            <td>{{ $dr->catatan }}</td>
                            <td>
                                <a href="daftar_req_gudang_kecil/{{ $dr->id }}/{{ $dr->nomor_po }}" class="btn btn-primary">
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
