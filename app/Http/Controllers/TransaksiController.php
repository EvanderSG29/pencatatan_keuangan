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
        // Validate arrays for multiple transaction entries
        $request->validate([
            'tanggal_transaksi' => 'required|array',
            'tanggal_transaksi.*' => 'required|date',
            'nama_transaksi' => 'required|array',
            'nama_transaksi.*' => 'required|string|max:255',
            'id_kategori' => 'required|array',
            'id_kategori.*' => 'required|exists:tb_kategori,id_kategori',
            'jenis_transaksi' => 'required|array',
            'jenis_transaksi.*' => 'required|string|max:255',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'nominal' => 'required|array',
            'nominal.*' => 'required|integer|min:0',
        ]);

        $userId = auth()->id();
        $count = count($request->input('nama_transaksi', []));

        // Create multiple transaction records
        for ($i = 0; $i < $count; $i++) {
            Transaksi::create([
                'id_user' => $userId,
                'tanggal_transaksi' => $request->input("tanggal_transaksi.$i"),
                'nama_transaksi' => $request->input("nama_transaksi.$i"),
                'id_kategori' => $request->input("id_kategori.$i"),
                'jenis_transaksi' => $request->input("jenis_transaksi.$i"),
                'qty' => $request->input("qty.$i"),
                'nominal' => $request->input("nominal.$i"),
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', $count . ' Transaksi berhasil ditambahkan.');
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
            'qty' => 'required|integer|min:1',
            'nominal' => 'required|integer',
        ]);

        $this->authorizeOwnership($transaksi);

        $transaksi->update($request->only(['tanggal_transaksi', 'nama_transaksi', 'id_kategori', 'jenis_transaksi', 'qty', 'nominal']));

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
