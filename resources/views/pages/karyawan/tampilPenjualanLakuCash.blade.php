@extends('layouts.karyawan')
@section('karyawan.body')
    <div class="mt-4">
        <a href="/user/penjualan_laku_cash" class="btn btn-outline-secondary mb-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>
    
    <div class="card mb-4 mt-4">
        <div class="card-header">
            <h2>Detail Penjualan</h2>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Beli</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total = 0;
                        $totalbeli = 0;
                    @endphp
                    @foreach ($data as $dt)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $dt->id_produk }}</td>
                            <td>{{ $dt->nama_produk }}</td>
                            <td>{{ $dt->jumlah_produk }}</td>
                            <td>Rp {{ number_format($dt->jumlah_produk * $dt->harga_toko, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $no++;
                            $total += ($dt->jumlah_produk * $dt->harga_toko);
                            $totalbeli += ($dt->jumlah_produk);
                        @endphp
                    @endforeach     
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total</th>
                        <th>{{ $total }}</th>
                    </tr>
                </tfoot>     
            </table>
        </div>
        

    </div>

    <div style="text-align: right;">
        <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Beli</b></label>
        <input type="text" style="text-align: left;" value="{{ $totalbeli }}" disabled>
      </div>
      <br>
      <div style="text-align: right;">
        <label style="display: inline-block; width: 150px; font-weight: bold; text-align: left;"><b>Total Harga</b></label>
        <input type="text" style="text-align: left;" value="Rp {{ number_format($total, 0, ',', '.') }}" disabled><br><br>
      </div>
      
          

    <script src="{{ asset('js/custom.js') }}"></script>
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            let table = $('#datatablesSimple').DataTable( {
                fixedHeader: {
                    header: true,
                    footer: true
                }
            } );
        });
    </script>     --}}
@endsection
