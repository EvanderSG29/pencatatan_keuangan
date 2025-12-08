<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with('kategori')->where('id_user', auth()->id())->get();
        return view('Transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::where('id_user', auth()->id())->get();
        return view('Transaksi.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nama_transaksi' => 'required|string|max:255',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'jenis_transaksi' => 'required|string|max:255',
            'nominal' => 'required|integer',
        ]);

        $data = $request->only(['tanggal_transaksi', 'nama_transaksi', 'id_kategori', 'jenis_transaksi', 'nominal']);
        $data['id_user'] = auth()->id();

        Transaksi::create($data);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        $this->authorizeOwnership($transaksi);

        return view('Transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $this->authorizeOwnership($transaksi);

        $kategoris = Kategori::where('id_user', auth()->id())->get();
        return view('Transaksi.edit', compact('transaksi', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nama_transaksi' => 'required|string|max:255',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'jenis_transaksi' => 'required|string|max:255',
            'nominal' => 'required|integer',
        ]);

        $this->authorizeOwnership($transaksi);

        $transaksi->update($request->only(['tanggal_transaksi', 'nama_transaksi', 'id_kategori', 'jenis_transaksi', 'nominal']));

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $this->authorizeOwnership($transaksi);

        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Pastikan transaksi dimiliki oleh user yang sedang login.
     */
    private function authorizeOwnership(Transaksi $transaksi)
    {
        if ($transaksi->id_user != auth()->id()) {
            abort(403);
        }
    }
}
