@extends('layouts.admin2')
@section('admin2.body')
    <main>
        <a href="/admin2/request_sales" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <h3>Detail Barang Request Sales : {{ $sales[0]->nama }}</h3>
        <div class="mt-4">
			<form action="{{ $sales[0]->id }}/konfirmasi" method="post" onsubmit="return confirm('Konfirmasi Request Sales?')">
				@csrf
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->tanggal_request }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->jumlah }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning ubah-stok" style="margin-right: 0.5rem;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $dt->id_produk }}">
                                        Ubah Stok
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal-{{ $dt->id_produk }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form class="modal-content" action="{{ $dt->id_user }}/ubah_stok/{{ $dt->id_produk }}" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>
                                                        <label for="{{ $dt->id_produk }}" class="form-label">{{ $dt->nama_produk }}</label>
                                                        <input min="0" type="number" id="B20" name="jumlah"
                                                            placeholder="{{ $dt->id_produk }}" class="form-control" value="{{ $dt->jumlah }}"><br>
                                                        <input type="hidden" name="id_produk" value="{{ $dt->id_produk }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-warning">Ubah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
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
