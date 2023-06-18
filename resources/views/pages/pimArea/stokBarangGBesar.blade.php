@extends('layouts.pimArea')
@section('pimArea.body')
<div class="mt-5">
    <div class="card mb-4">
        <div class="card-header">
            <h2>STOK GUDANG BESAR</h2>
        </div>
        <div class="card-body">
            {{-- <a href="#">History</a> --}}
            <div class="my-2">
            </div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Sample</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($stokSample as $sp)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $sp->id_produk }}</td>
                            <td>{{ $sp->stok }}</td>
                            <td>{{ $sp->sample }}</td>
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
