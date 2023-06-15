@extends('layouts.gBesar')
@section('gBesar.body')
    <main>
        <a href="/gBesar/request_gKecil" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <div class="mt-4">
			<form action="{{ $nomor_po[0]->nomor_po }}/konfirmasi" method="post" onsubmit="return confirm('Konfirmasi Request Sales?')">
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
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->created_at }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->stok }}</td>
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
