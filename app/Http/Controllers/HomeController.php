<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $userId = auth()->id();

        // ======================
        // 1. STATISTIK UTAMA
        // =======================

        $pemasukan = Transaksi::where('jenis_transaksi', 'Pemasukan')
            ->where('id_user', $userId)
            ->sum('total_nominal') ?? 0;

        $pengeluaran = Transaksi::where('jenis_transaksi', 'Pengeluaran')
            ->where('id_user', $userId)
            ->sum('total_nominal') ?? 0;

        $sisaSaldo = $pemasukan - $pengeluaran;

        $totalTransaksi = Transaksi::where('id_user', $userId)->count();

        $recentTransaksi = Transaksi::where('id_user', $userId)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ======================
        // 2. TOP 3 KATEGORI
        // ======================

        $pengeluaranTop = DB::table('tb_transaksi')
            ->join('tb_kategori', 'tb_transaksi.id_kategori', '=', 'tb_kategori.id_kategori')
            ->where('tb_transaksi.jenis_transaksi', 'Pengeluaran')
            ->where('tb_transaksi.id_user', $userId)
            ->select('tb_kategori.nama_kategori', DB::raw('SUM(tb_transaksi.total_nominal) as total_pengeluaran'))
            ->groupBy('tb_kategori.id_kategori', 'tb_kategori.nama_kategori')
            ->orderByDesc('total_pengeluaran')
            ->limit(3)
            ->get();

        $pemasukanTop = DB::table('tb_transaksi')
            ->join('tb_kategori', 'tb_transaksi.id_kategori', '=', 'tb_kategori.id_kategori')
            ->where('tb_transaksi.jenis_transaksi', 'Pemasukan')
            ->where('tb_transaksi.id_user', $userId)
            ->select('tb_kategori.nama_kategori', DB::raw('SUM(tb_transaksi.total_nominal) as total_pemasukan'))
            ->groupBy('tb_kategori.id_kategori', 'tb_kategori.nama_kategori')
            ->orderByDesc('total_pemasukan')
            ->limit(3)
            ->get();


        // =================================================================
        // 3. LINE CHART (12 bulan atau filter manual)
        // =================================================================

        $start = $request->start_date;
        $end   = $request->end_date;

        $chartQuery = DB::table('tb_transaksi')
            ->select(
                DB::raw("DATE(tanggal_transaksi) as tgl"),
                DB::raw("SUM(CASE WHEN jenis_transaksi = 'Pemasukan' THEN total_nominal ELSE 0 END) as pemasukan"),
                DB::raw("SUM(CASE WHEN jenis_transaksi = 'Pengeluaran' THEN total_nominal ELSE 0 END) as pengeluaran")
            )
            ->where('id_user', $userId);

        if ($start && $end) {
            $chartQuery->whereBetween('tanggal_transaksi', [$start, $end]);
        } else {
            // default: 12 bulan terakhir
            $chartQuery->where('tanggal_transaksi', '>=', Carbon::now()->subMonths(12));
        }

        $chartData = $chartQuery
            ->groupBy(DB::raw("DATE(tanggal_transaksi)"))
            ->orderBy('tgl', 'ASC')
            ->get();

        $labels = $chartData->pluck('tgl')->map(fn($d) => Carbon::parse($d)->format('d M'));
        $chartPemasukan   = $chartData->pluck('pemasukan');
        $chartPengeluaran = $chartData->pluck('pengeluaran');


        // =================================================================
        // 4. DONUT CHART – kategori pemasukan & pengeluaran
        // =================================================================

        // Label kategori user
        $kategoriLabels = DB::table('tb_kategori')
            ->where('id_user', $userId)
            ->pluck('nama_kategori');

        $pemasukanKategori = DB::table('tb_transaksi')
            ->select('id_kategori', DB::raw('SUM(nominal) as total'))
            ->where('jenis_transaksi', 'Pemasukan')
            ->where('id_user', $userId)
            ->groupBy('id_kategori')
            ->pluck('total');

        $pengeluaranKategori = DB::table('tb_transaksi')
            ->select('id_kategori', DB::raw('SUM(nominal) as total'))
            ->where('jenis_transaksi', 'Pengeluaran')
            ->where('id_user', $userId)
            ->groupBy('id_kategori')
            ->pluck('total');


        // =================================================================
        // RETURN KE VIEW
        // =================================================================

        return view('home', compact(
            'pemasukan',
            'pengeluaran',
            'sisaSaldo',
            'pengeluaranTop',
            'pemasukanTop',
            'totalTransaksi',
            'recentTransaksi',

            // line chart
            'labels',
            'chartPemasukan',
            'chartPengeluaran',
            'start',
            'end',

            // donut
            'kategoriLabels',
            'pemasukanKategori',
            'pengeluaranKategori',
        ));
    }
}

