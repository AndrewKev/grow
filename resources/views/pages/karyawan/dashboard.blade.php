@extends('layouts.karyawan')
@section('karyawan.body')
    <main>
        <h1>Dashboard Karyawan</h1>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Area Chart Example
                    </div>
                    <div class="card-body">
                        <canvas id="myChartEft" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
    </main>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"
        integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- @php
            $tes = 0;
        @endphp --}}
    {{ $efektivitas->get('Senin') ? $efektivitas->get('Senin') : 0 }}
    <script>
        const ctx = document.getElementById('myChartEft');

        let senin = {{ $efektivitas->get('Senin') ? $efektivitas->get('Senin') : 0 }}
        let selasa = {{ $efektivitas->get('Selasa') ? $efektivitas->get('Selasa') : 0 }}
        let rabu = {{ $efektivitas->get('Rabu') ? $efektivitas->get('Rabu') : 0 }}
        let kamis = {{ $efektivitas->get('Kamis') ? $efektivitas->get('Kamis') : 0 }}
        let jumat = {{ $efektivitas->get('Jumat') ? $efektivitas->get('Jumat') : 0 }}
        let sabtu = {{ $efektivitas->get('Sabtu') ? $efektivitas->get('Sabtu') : 0 }}
        // let tes = 0
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                datasets: [{
                    label: 'Efektivitas',
                    data: [senin, selasa, rabu, kamis, jumat, sabtu],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
@endsection
