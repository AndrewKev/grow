@extends('layouts.admin')
@section('admin.body')
    <main>
        <h2>History Request Sales Stor Penjualan</h2>
        <div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Sales</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($historyReqSalesSU as $his)
                   <tr>
                        <th>{{ $no }}</th>
                        <th>{{ $his->created_at }}</th>
                        <th>{{ $his->nama_sales }}</a></th>
                        <th><a href="history_request_stor_penjualan/{{ $his->keterangan }}/{{ $his->nama_sales }}">{{ $his->keterangan }}</a></th>
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
