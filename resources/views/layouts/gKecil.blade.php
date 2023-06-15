@extends('layouts.master')
@section('body')
	<div id="layoutSidenav_nav">
		<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
			<div class="sb-sidenav-menu">
				<div class="nav">
					<div class="sb-sidenav-menu-heading">Core</div>
					<a class="nav-link" href="/gKecil/">
						<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
						Dashboard
					</a>
					<div class="sb-sidenav-menu-heading">Menu</div>
					<nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
						<a class="nav-link" href="/gKecil/stok_barang">Stok Gudang Kecil</a>
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
			@yield('gKecil.body')
		</div>
	</div>
@endsection
