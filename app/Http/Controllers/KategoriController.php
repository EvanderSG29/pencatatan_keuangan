<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $kategoris = Kategori::where('id_user', auth()->id())->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $data = $request->only('nama_kategori');
        $data['id_user'] = auth()->id();

        Kategori::create($data);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori)
    {
        $this->authorizeOwnership($kategori);

        return view('kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori)
    {
        $this->authorizeOwnership($kategori);

        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $this->authorizeOwnership($kategori);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $this->authorizeOwnership($kategori);

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Pastikan resource dimiliki oleh user yang sedang login.
     */
    private function authorizeOwnership(Kategori $kategori)
    {
        if ($kategori->id_user != auth()->id()) {
            abort(403);
        }
    }
}
