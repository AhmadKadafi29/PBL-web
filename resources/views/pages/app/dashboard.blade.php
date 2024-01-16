@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <!-- Card for Total Obat -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-pills"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Obat</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlahObat }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Total Supplier -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-boxes-packing"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Supplier</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlahSupplier }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Total Penjualan -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Penjualan</h4>
                            </div>
                            <div class="card-body">
                                {{ $jumlahPenjualan }}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Online Users -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Online Users</h4>
                            </div>
                            <div class="card-body">
                                47
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary" id="btnWeek">Week</a>
                                    <a href="#" class="btn" id="btnMonth">Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Canvas for Chart -->
                            <canvas id="myChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        // Fetch real data from your database using AJAX
        function fetchData(duration) {
            // Replace this with your actual API endpoint
            fetch(`/chart/${duration}`)
                .then(response => response.json())
                .then(data => {
                    updateChart(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat',
                    'Sabtu'
                ], // Labels will be populated dynamically
                datasets: [{
                    label: 'Weekly Sales',
                    data: [0, 10, 5, 2, 20], // Data will be populated dynamically
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Event listeners for the Week and Month buttons
        document.getElementById('btnWeek').addEventListener('click', function() {
            fetchData('weekly');
        });

        document.getElementById('btnMonth').addEventListener('click', function() {
            fetchData('monthly');
        });

        // Function to update chart with new data
        function updateChart(data) {
            myChart.data.labels = data.labels;

            // Assign data directly without multiplication
            myChart.data.datasets[0].data = data.data;

            myChart.update();
        }

        // Initial fetch for week data
        fetchData('weekly');
    </script>
@endpush
