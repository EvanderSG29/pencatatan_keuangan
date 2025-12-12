@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="font-weight-bold mb-0">Dashboard Keuangan</h3>
        <small class="text-muted">Ringkasan aktivitas finansial Anda</small>
    </div>

    {{-- ============================
        BARIS 1 - 4 KARTU UTAMA
    ============================ --}}
    <div class="row">

        {{-- PEMASUKAN --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Pemasukan</p>
                        <h4>Rp {{ number_format($pemasukan,0,',','.') }}</h4>
                    </div>
                    <div class="icon-box bg-success text-white">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- PENGELUARAN --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Pengeluaran</p>
                        <h4>Rp {{ number_format($pengeluaran,0,',','.') }}</h4>
                    </div>
                    <div class="icon-box bg-danger text-white">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISA SALDO --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Sisa Saldo</p>
                        <h4>Rp {{ number_format($sisaSaldo,0,',','.') }}</h4>
                    </div>
                    <div class="icon-box bg-primary text-white">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL TRANSAKSI --}}
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Total Transaksi</p>
                        <h4>{{ $totalTransaksi }}</h4>
                    </div>
                    <div class="icon-box bg-secondary text-white">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- ============================
        BARIS 2 - LINE CHART FULL
    ============================ --}}
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Keuangan (Rentang 12 Bulan)</h5>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" height="110"></canvas>
                </div>
            </div>
        </div>
    </div>


    {{-- ============================
        BARIS 3 - DONUT + KATEGORI
    ============================ --}}
    <div class="row">

        {{-- DONUT PENGELUARAN --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Pengeluaran per Kategori</h5>
                </div>
                <div class="card-body text-center">
                    <canvas id="donutPengeluaran" height="180"></canvas>
                </div>
            </div>
        </div>

        {{-- DONUT PEMASUKAN --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Pemasukan per Kategori</h5>
                </div>
                <div class="card-body text-center">
                    <canvas id="donutPemasukan" height="180"></canvas>
                </div>
            </div>
        </div>

        {{-- SEMUA KATEGORI (scroll) --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-tags mr-2"></i>Daftar Kategori</h5>
                </div>
                <div class="card-body p-0" style="max-height: 290px; overflow-y:auto;">
                    <ul class="list-group list-group-flush">
                        @foreach($kategoriLabels as $idx => $kat)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $kat }}</span>
                                <strong>RP 
                                    {{ number_format(($pemasukanKategori[$idx] ?? 0) + ($pengeluaranKategori[$idx] ?? 0),0,',','.') }}
                                </strong>
                            </li>
                        @endforeach
                    </ul>
                    
                </div>
                <div class="">
                    <small class="text-muted d-block p-2">* Total dari pemasukan dan pengeluaran per kategori</small>
                </div>
            </div>
        </div>

    </div>



    {{-- ============================
        BARIS 4 - HISTORY (2 kolom)
    ============================ --}}
    <div class="row">

        {{-- HISTORY LEFT --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-history mr-2"></i>Transaksi Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    @include('partials.history-table', ['data' => $recentTransaksi])
                </div>
            </div>
        </div>

        {{-- HISTORY RIGHT (isi sama) --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-history mr-2"></i>Transaksi Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    @include('partials.history-table', ['data' => $recentTransaksi])
                </div>
            </div>
        </div>

    </div>

</div>
@endsection



{{-- ============================
    CUSTOM CSS
============================ --}}
@section('css')
<style>
.icon-box {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
}
.list-group-item {
    padding: 10px 15px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .icon-box {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }
    .card-body h4 {
        font-size: 1.2rem;
    }
    .card-body p {
        font-size: 0.9rem;
    }
    .table-responsive {
        font-size: 0.85rem;
    }
    .btn {
        font-size: 0.9rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Make charts responsive */
canvas {
    max-width: 100% !important;
    height: auto !important;
}
</style>
@endsection



{{-- ============================
    CHART.JS
============================ --}}
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ===========================
    DATA DARI CONTROLLER
=========================== */
const labels = {!! json_encode($labels) !!};
const pemasukanLine = {!! json_encode($chartPemasukan) !!};
const pengeluaranLine = {!! json_encode($chartPengeluaran) !!};

const kategoriLabels = {!! json_encode($kategoriLabels) !!};
const pemasukanKategori = {!! json_encode($pemasukanKategori) !!};
const pengeluaranKategori = {!! json_encode($pengeluaranKategori) !!};


/* ===========================
    LINE CHART
=========================== */
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Pemasukan',
                data: pemasukanLine,
                borderColor: '#28a745',
                fill: false,
                tension: 0.3
            },
            {
                label: 'Pengeluaran',
                data: pengeluaranLine,
                borderColor: '#dc3545',
                fill: false,
                tension: 0.3
            }
        ]
    },
    options: { responsive: true }
});


/* ===========================
    DONUT PENGELUARAN
=========================== */
new Chart(document.getElementById('donutPengeluaran'), {
    type: 'doughnut',
    data: {
        labels: kategoriLabels,
        datasets: [{
            data: pengeluaranKategori,
            backgroundColor: ['#ff6384','#36a2eb','#ffce56','#4bc0c0','#9966ff','#ff9f40'],
        }]
    }
});


/* ===========================
    DONUT PEMASUKAN
=========================== */
new Chart(document.getElementById('donutPemasukan'), {
    type: 'doughnut',
    data: {
        labels: kategoriLabels,
        datasets: [{
            data: pemasukanKategori,
            backgroundColor: ['#36a2eb','#4bc0c0','#9966ff','#ffce56','#ff6384','#ff9f40'],
        }]
    }
});
</script>
@endsection
