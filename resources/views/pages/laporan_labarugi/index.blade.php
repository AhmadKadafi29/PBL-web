@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan Laba Rugi</h1>
            </div>

            <div class="section-body">
                <div class="container mt-4">
                    <h2>Generate Laporan Laba Rugi per Bulan</h2>
                    <form action="{{ route('labarugi.generate') }}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" class="form-control" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun" class="form-control" required>
                                        @php
                                            $currentYear = date('Y');
                                        @endphp
                                        @for ($year = $currentYear; $year >= $currentYear - 10; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <button type="submit" class="btn btn-primary">Generate Laporan</button>
                            </div>
                        </div>
                    </form>

                    @if (isset($labaRugi))
                        <h3 class="mt-4">Laporan Laba Rugi Bulan {{ date('F', mktime(0, 0, 0, $bulan, 1)) }} Tahun
                            {{ $tahun }}</h3>
                        <p class="mt-3">Berikut adalah ringkasan laporan laba rugi perusahaan untuk bulan dan tahun yang
                            dipilih:</p>

                        <div class="row">
                            <div class="col-md-4">
                                <strong>Total Pendapatan:</strong> Rp. {{ $totalPendapatan }}
                            </div>
                            <div class="col-md-4">
                                <strong>Total Biaya:</strong> Rp. {{ $totalBiaya }}
                            </div>
                            <div class="col-md-4">
                                <strong>Laba Rugi:</strong> Rp. {{ $labaRugi }}
                            </div>
                        </div>

                        <p class="mt-3">Terlampir juga laporan lengkapnya dalam format PDF:</p>
                        <a href="{{ url('/laporan-labarugi/cetaklaporan?bulan=' . $bulan . '&tahun=' . $tahun) }}"
                            class="btn btn-primary">Cetak Laporan</a>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
