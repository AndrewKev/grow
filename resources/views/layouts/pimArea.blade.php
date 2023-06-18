@extends('layouts.master')
@section('body')
	<div id="layoutSidenav_nav">
		<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
			<div class="sb-sidenav-menu">
				<div class="nav">
					<div class="sb-sidenav-menu-heading">Core</div>
					<a class="nav-link" href="/pimArea/">
						<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
						Dashboard
					</a>
					<div class="sb-sidenav-menu-heading">Menu</div>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/pimArea/stok_gudang_besar">Stok Gudang Besar</a>
					</nav>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/pimArea/stok_gudang_kecil">Stok Gudang Kecil</a>
					</nav>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/pimArea/daftar_req_gudang_kecil">Request Stok Gudang Kecil</a>
					</nav>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/pimArea/history_request_barang_gKecil">History Gudang Kecil</a>
					</nav>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/pimArea/tampil_absensi">Daftar Absensi</a>
					</nav>
				</div>
			</div>
			<div class="sb-sidenav-footer">
				<div class="small">Masuk sebagai:</div>
				<h3>{{ auth()->user()->nama }}</h3>
			</div>
		</nav>
	</div>
	<div id="layoutSidenav_content">
		<div class="container-fluid px-4 mt-4">
			@yield('pimArea.body')
		</div>
	</div>
@endsection
