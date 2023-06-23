@extends('layouts.master')
@section('head')
    <script type="text/javascript">
        window.onload = function() {
            getLocation();
        };

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitudeInput").value = latitude;
            document.getElementById("longitudeInput").value = longitude;
            document.getElementById("latitudeOutput").innerText = "Latitude: " + latitude;
            document.getElementById("longitudeOutput").innerText = "Longitude: " + longitude;
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("Anda Harus Mengijinkan Geo Location untuk mengisi form");
                    break;
                default:
                    alert("Gagal mengambil lokasi: " + error.message);
                    break;
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"
        integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@section('body')
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="/spo/dashboard">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="/spo/absensi">Absensi</a>
                        <a class="nav-link" href="/spo/stok_jalan">Stok Jalan</a>
                        <a class="nav-link" href="/spo/penjualan_spo">Penjualan SPO</a>
                        <a class="nav-link" href="/spo/stor_produk">Stor Produk</a>
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
        <div class="container-fluid px-4">
            @yield('spo.body')
        </div>
    </div>
@endsection
