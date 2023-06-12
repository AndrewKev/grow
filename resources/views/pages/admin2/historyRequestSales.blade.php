@extends('layouts.admin2')
@section('admin2.body')
    <main>
        <h2>History Request Sales</h2>
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
                    @foreach ($historyReqSales as $his)
                   <tr>
                        <th>{{ $no }}</th>
                        <th>{{ $his->tanggal }}</th>
                        <th>{{ $his->nama_sales }}</a></th>
                        <th><a href="history_request_sales/{{ $his->keterangan }}">{{ $his->keterangan }}</a></th>
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
