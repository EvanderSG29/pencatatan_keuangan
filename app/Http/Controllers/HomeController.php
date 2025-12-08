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

        // Find the category with the highest total expense for this user
        $pengeluaranTerbanyakKategori = DB::table('tb_transaksi')
            ->join('tb_kategori', 'tb_transaksi.id_kategori', '=', 'tb_kategori.id_kategori')
            ->where('tb_transaksi.jenis_transaksi', 'Pengeluaran')
            ->where('tb_transaksi.id_user', $userId)
            ->select('tb_kategori.nama_kategori', DB::raw('SUM(tb_transaksi.nominal) as total_pengeluaran'))
            ->groupBy('tb_kategori.id_kategori', 'tb_kategori.nama_kategori')
            ->orderByDesc('total_pengeluaran')
            ->first();

        return view('home', compact('pemasukan', 'pengeluaran', 'sisaSaldo', 'pengeluaranTerbanyakKategori'));
    }
}
