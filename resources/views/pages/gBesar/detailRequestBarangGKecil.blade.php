@extends('layouts.gBesar')
@section('gBesar.body')
    <main>
        <a href="/gBesar/request_gKecil" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
        <div class="mt-4">
			<form action="{{ $user[0]->id }}/konfirmasi" method="post" onsubmit="return confirm('Konfirmasi Request Sales?')">
				@csrf
                @foreach ($dataBarangKonfirmasi as $index => $brg)
                    <input type="hidden" name="id_produk[{{ $index }}]" value="{{ $brg->id_produk }}">
                    <input type="hidden" name="nama_produk[{{ $index }}]" value="{{ $brg->nama_produk }}">
                    <input type="hidden" name="stok[{{ $index }}]" value="{{ $brg->stok }}">
                @endforeach
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalKurangStok">
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
        <!-- Modal -->
    <!-- Modal Cek Barang -->
    {{-- <div class="modal fade" id="modalKurangStok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="/user/terima_barang" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach ($barangKonfirmasi as $brg)
                        <div>
                            <label class="form-label">{{ $brg->nama_produk }}</label>
                            <input min="0" type="number" placeholder=""
                                class="form-control" value="{{ $brg->jumlah }}" disabled><br>
                            <input type="hidden" name="id_produk[]" value="{{ $brg->id_produk }}">
                            <input type="hidden" name="nama_produk[]" value="{{ $brg->nama_produk }}">
                            <input type="hidden" name="jumlah[]" value="{{ $brg->jumlah }}">
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" name="batal" class="btn btn-danger" onclick="return confirm('Yakin tidak ingin menerima barang?')">Batal</button>
                    <button type="submit" name="setuju" class="btn btn-success" onclick="return confirm('Terima barang?')">Setuju</button>
                </div>
            </form>
        </div>
    </div> --}}
    </main>
@endsection
