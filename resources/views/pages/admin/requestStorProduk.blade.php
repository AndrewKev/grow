@extends('layouts.admin')
@section('admin.body')
    <main>
        <h2>Daftar Request Sales Stor Penjualan</h2>
        <div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Sales</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($daftarReqStorUang as $req)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $req->tanggal_stor_barang }}</td>
                            <td>{{ $req->nama }}</td>
                            <td>
                                <a href="request_stor_uang/{{ $req->id }}" class="btn btn-primary">
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
