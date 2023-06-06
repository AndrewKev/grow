@extends('layouts.admin')
@section('admin.body')
    <main>
        <a href="/admin/request_stor_uang" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail Barang Request Sales : {{ $sales[0]->nama }}</h3>
        <div class="mt-4">
			<form action="{{ $sales[0]->id }}/konfirmasi" method="post" onsubmit="return confirm('Konfirmasi Request Sales?')">
				@csrf
				<button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editkm">
					Konfirmasi
				</button>
			</form>
        </div>
        <div class="card mb-4 mt-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Produk</th>
                            <th>Terjual</th>
                            <th>Harga Barang</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->tanggal_stor_uang }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->terjual }}</td>
                                <td>{{ $dt->harga_produk }}</td>
                                <td>{{ $dt->total_harga }}</td>
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
