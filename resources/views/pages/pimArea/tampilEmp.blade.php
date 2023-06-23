@extends('layouts.pimArea')
@section('pimArea.body')
    <main>
        <h2>Daftar EMP</h2>
        <div class="card-body">
            <div class="mt-4">
            </div>
            <div class="mt-4">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            {{-- <th>Jabatan</th> --}}
                            <th>Jumlah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($listEmp as $emp)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $emp->jenis }}</td>
                                <td>{{ $emp->jumlah }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning ubah-stok" style="margin-right: 1.0 rem;"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $emp->jenis }}">
                                        Ubah Stok
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal-{{ $emp->jenis }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <form class="modal-content" action="tampil_emp/{{ $emp->jenis }}/ubah_stok" method="post">
                                                @csrf
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah EMP</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>
                                                        <label for="{{ $emp->jenis }}" class="form-label">{{ $emp->jenis }}</label>
                                                        <input min="0" type="number"  name="jumlah"
                                                            placeholder="{{ $emp->jenis }}" class="form-control" value="{{ $emp->jumlah }}"><br>
                                                        <input type="hidden" name="id_produk" value="{{ $emp->jenis }}">
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
