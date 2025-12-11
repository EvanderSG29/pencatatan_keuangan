@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
 <div class="container_fluid">
<div class="row mb-2">
    <div class="col-sm-6">
        <H1>Beranda</H1>
    </div>
 </div>
 </div>
 @stop

@section('content')
    <!-- Main Statistics Row -->
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Rp {{ number_format($pemasukan ?? 0, 0, ',', '.') }}</h4>
                    <p>Pemasukan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-up text-white"></i>
                </div>
                <br>
                <a href="{{ route('transaksi.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>Rp {{ number_format($pengeluaran ?? 0, 0, ',', '.') }}</h4>
                    <p>Pengeluaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-down text-white"></i>
                </div>
                <br>
                <a href="{{ route('transaksi.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h4>Rp {{ number_format($sisaSaldo ?? 0, 0, ',', '.') }}</h4>
                    <p>Sisa Saldo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet text-white"></i>
                </div>
                <br>
                <a href="{{ route('transaksi.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h4>{{ $totalTransaksi }}</h4>
                    <p>Total Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-list text-white"></i>
                </div>
                <br>
                <a href="{{ route('transaksi.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Analisis Kategori & Recent Transactions Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i> Analisis Kategori</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Pengeluaran Terbanyak</h5>
                            @if(isset($pengeluaranTop) && $pengeluaranTop->count())
                                <ol>
                                    @foreach($pengeluaranTop as $item)
                                        <li>{{ $item->nama_kategori }} — <strong>Rp {{ number_format($item->total_pengeluaran, 0, ',', '.') }}</strong></li>
                                    @endforeach
                                </ol>
                            @else
                                <div class="text-muted">Belum ada data pengeluaran</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Pemasukan Terbanyak</h5>
                            @if(isset($pemasukanTop) && $pemasukanTop->count())
                                <ol>
                                    @foreach($pemasukanTop as $item)
                                        <li>{{ $item->nama_kategori }} — <strong>Rp {{ number_format($item->total_pemasukan, 0, ',', '.') }}</strong></li>
                                    @endforeach
                                </ol>
                            @else
                                <div class="text-muted">Belum ada data pemasukan</div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <canvas id="donutPengeluaran" style="max-width:260px;margin:0 auto;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Kategori</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Transaksi Terbaru
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if ($recentTransaksi->count() > 0)
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Jenis</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTransaksi as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->nama_transaksi }}</td>
                                        <td>{{ $transaksi->kategori->nama_kategori ?? 'N/A' }}</td>
                                        <td>
                                            @if ($transaksi->jenis_transaksi == 'Pemasukan')
                                                <span class="badge badge-success">Pemasukan</span>
                                            @else
                                                <span class="badge badge-danger">Pengeluaran</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info m-2">Belum ada transaksi</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2"></i>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Transaksi
                    </a>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-info">
                        <i class="fas fa-list"></i> Lihat Semua Transaksi
                    </a>
                    <a href="{{ route('kategori.index') }}" class="btn btn-warning">
                        <i class="fas fa-tags"></i> Kelola Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <style>
        /* Small dashboard tweaks */
        .card .card-title i { margin-right: 8px; }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!");</script>



    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@0.5.7"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    (function(){
        const labels = {!! json_encode(isset($pengeluaranTop) ? $pengeluaranTop->pluck('nama_kategori') : []) !!};
        const dataVals = {!! json_encode(isset($pengeluaranTop) ? $pengeluaranTop->pluck('total_pengeluaran') : []) !!};

        const canvas = document.getElementById('donutPengeluaran');
        if (canvas && labels.length) {
            const ctx = canvas.getContext('2d');
            const bgColors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
            ];
            const colors = labels.map((_, i) => bgColors[i % bgColors.length]);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataVals,
                        backgroundColor: colors,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12 } },
                        tooltip: { callbacks: { label: function(ctx) { return 'Rp ' + Number(ctx.raw).toLocaleString('id-ID'); } } }
                    }
                }
            });
        }
    })();
    </script>
@stop