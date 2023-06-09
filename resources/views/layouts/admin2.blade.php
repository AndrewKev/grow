@extends('layouts.master')
@section('body')
	<div id="layoutSidenav_nav">
		<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
			<div class="sb-sidenav-menu">
				<div class="nav">
					<div class="sb-sidenav-menu-heading">Core</div>
					<a class="nav-link" href="/admin2/">
						<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
						Dashboard
					</a>
					<div class="sb-sidenav-menu-heading">Menu</div>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/admin2/stok_barang_gKecil">Stok Gudang</a>
						<a class="nav-link" href="/admin2/request_sales">Request Sales</a>
						<a class="nav-link" href="/admin2/request_stor_barang">Request Sales Stor Barang</a>
						<a class="nav-link" href="/admin2/history_request_sales">History Request Sales</a>
						<a class="nav-link" href="/admin2/history_request_stor_barang">History Request Sales Stor Barang</a>
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
			@yield('admin2.body')
		</div>
	</div>
@endsection
