@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('page_heading', 'Daftar Kategori')

@section('card_header')
    <h3>Daftar Kategori</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
@stop

@section('card_body')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->id_kategori }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('kategori.show', $kategori) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
