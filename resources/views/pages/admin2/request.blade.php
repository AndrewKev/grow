@extends('layouts.admin')
@section('admin.body')
    <main>
        <h2>Daftar Request Sales</h2>
        <div>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Sales</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    <tr>
                        <td>{{ $no }}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form class="modal-content" action="/admin/konfirmasi" method="post">
					@csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <form action="/admin/konfirmasi" method="post" class="myForm" enctype="multipart/form-data"
                            id="formToko">
                            @csrf --}}
                        <div>
                            <label for="b20" class="form-label">GROW BOLD 20</label>
                            <input type="number" id="B20" name="produk[]" placeholder="B20" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B20">
                        </div>
                        <div>
                            <label for="b16" class="form-label">GROW BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="B16" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B16">
                        </div>
                        <div>
                            <label for="b12" class="form-label">GROW BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="B12" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="B12">
                        </div>
                        <div>
                            <label for="r16" class="form-label">GROW REG 16</label>
                            <input type="number" name="produk[]" placeholder="R16" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="R16">
                        </div>
                        <div>
                            <label for="r12" class="form-label">GROW REG 12</label>
                            <input type="number" name="produk[]" placeholder="R12" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="R12">
                        </div>
                        <div>
                            <label for="kk" class="form-label">GROW KRETEK KUNING 12</label>
                            <input type="number" name="produk[]" placeholder="KK" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="KK">
                        </div>
                        <div>
                            <label for="kc" class="form-label">GROW KRETEK COKLAT 12</label>
                            <input type="number" name="produk[]" placeholder="KC" class="form-control" value="0"><br>
                            <input type="hidden" name="id_produk[]" value="KC">
                        </div>
                        <div>
                            <label for="bb16" class="form-label">GROW BERRY BOLD 16</label>
                            <input type="number" name="produk[]" placeholder="BB16" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="BB16">
                        </div>
                        <div>
                            <label for="bb12" class="form-label">GROW BERRY BOLD 12</label>
                            <input type="number" name="produk[]" placeholder="BB12" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="BB12">
                        </div>
                        <div>
                            <label for="bice" class="form-label">GROW BLACK ICE 16</label>
                            <input type="number" name="produk[]" placeholder="BICE16" class="form-control"
                                value="0"><br>
                            <input type="hidden" name="id_produk[]" value="BICE16">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
