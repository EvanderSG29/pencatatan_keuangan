<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Calculate statistics for the authenticated user only
        $userId = auth()->id();

        $pemasukan = Transaksi::where('jenis_transaksi', 'Pemasukan')
            ->where('id_user', $userId)
            ->sum('nominal') ?? 0;

        $pengeluaran = Transaksi::where('jenis_transaksi', 'Pengeluaran')
            ->where('id_user', $userId)
            ->sum('nominal') ?? 0;

        $sisaSaldo = $pemasukan - $pengeluaran;

        // Top 3 categories by total expense for this user
        $pengeluaranTop = DB::table('tb_transaksi')
            ->join('tb_kategori', 'tb_transaksi.id_kategori', '=', 'tb_kategori.id_kategori')
            ->where('tb_transaksi.jenis_transaksi', 'Pengeluaran')
            ->where('tb_transaksi.id_user', $userId)
            ->select('tb_kategori.nama_kategori', DB::raw('SUM(tb_transaksi.nominal) as total_pengeluaran'))
            ->groupBy('tb_kategori.id_kategori', 'tb_kategori.nama_kategori')
            ->orderByDesc('total_pengeluaran')
            ->limit(3)
            ->get();

        // Top 3 categories by total income for this user
        $pemasukanTop = DB::table('tb_transaksi')
            ->join('tb_kategori', 'tb_transaksi.id_kategori', '=', 'tb_kategori.id_kategori')
            ->where('tb_transaksi.jenis_transaksi', 'Pemasukan')
            ->where('tb_transaksi.id_user', $userId)
            ->select('tb_kategori.nama_kategori', DB::raw('SUM(tb_transaksi.nominal) as total_pemasukan'))
            ->groupBy('tb_kategori.id_kategori', 'tb_kategori.nama_kategori')
            ->orderByDesc('total_pemasukan')
            ->limit(3)
            ->get();

        // Get total transactions count
        $totalTransaksi = Transaksi::where('id_user', $userId)->count();

        // Get recent transactions
        $recentTransaksi = Transaksi::where('id_user', $userId)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact(
            'pemasukan', 
            'pengeluaran', 
            'sisaSaldo', 
            'pengeluaranTop',
            'pemasukanTop',
            'totalTransaksi',
            'recentTransaksi'
        ));
    }
}
