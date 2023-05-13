@extends('layouts.master')
@section('body')
	<div id="layoutSidenav_nav">
		<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
			<div class="sb-sidenav-menu">
				<div class="nav">
					<div class="sb-sidenav-menu-heading">Core</div>
					<a class="nav-link" href="index.php">
						<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
						Dashboard
					</a>
					<div class="sb-sidenav-menu-heading">Menu</div>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link active" href="absensi.php">Absensi</a>
						<a class="nav-link" href="stok_jalan.php">Stok Jalan</a>
						<a class="nav-link" href="stok_gudang_besar.php">Stok Gudang Besar</a>
						<a class="nav-link" href="stok_gudang_kecil.php">Stok Gudang Kecil</a>
						<a class="nav-link" href="pengajuanProduk.php">Pengajuan Produk</a>
						<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
							aria-expanded="false" aria-controls="collapsePages">
							<!-- <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div> -->
							Penjualan
							<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
							data-bs-parent="#sidenavAccordion">
							<div class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
								<a class="nav-link" href="#">Penjualan non-SPO</a>
								<a class="nav-link" href="#">Penjualan SPO</a>
							</div>
						</div>
					</nav>
				</div>
			</div>
			<div class="sb-sidenav-footer">
				<div class="small">Logged in as:</div>
				{{-- <h3>{{ auth()->user()->nama }}</h3> --}}
			</div>
		</nav>
	</div>
	<div id="layoutSidenav_content">
		<div class="container-fluid px-4">
			@yield('karyawan.body')
		</div>
	</div>
@endsection
