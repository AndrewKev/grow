@extends('layouts.admin2')
@section('admin2.body')
    <main>
        <a href="/admin2/request_stor_barang" class="btn btn-outline-secondary mb-2">
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
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                            $totaljual = 0;
                            $totalsisastok = 0;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->tanggal_stor_barang }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->terjual }}</td>
                                
                            </tr>
                            @php
                                $no++;
                                $totaljual += ($dt->terjual);
                                $totalsisastok += ($dt->sisa_stok);
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Terjual</b></label>
            <input type="text" style="text-align: left;" value="{{ $totaljual }}" disabled>
          </div>
          <br>
          <div style="text-align: right;">
            <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Sisa Stok</b></label>
            <input type="text" style="text-align: left;" value="{{ $totalsisastok }}" disabled><br><br>
          </div>
    </main>
@endsection
