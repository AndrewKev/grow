@extends('layouts.pimArea')
@section('pimArea.body')
    <main>
        <a href="/pimArea/daftar_req_gudang_kecil" class="btn btn-outline-secondary mb-2">
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
                            <th>Harga Stok</th>
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
                                <td>{{ $dt->created_at }}</td>
                                <td>{{ $dt->nama_produk }}</td>
                                <td>{{ $dt->stok }}</td>
                                <td>{{ $dt->harga_stok }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning ubah-stok" style="margin-right: 0.5rem;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $dt->id_produk }}">
                                        Ubah Stok
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal-{{ $dt->id_produk }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form class="modal-content" action="{{ $dt->nomor_po }}/ubah_stok/{{ $dt->id_produk }}" method="post">
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
                                                            placeholder="{{ $dt->id_produk }}" class="form-control" value="{{ $dt->stok }}"><br>
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
