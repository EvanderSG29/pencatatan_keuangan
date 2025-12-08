@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('page_heading', 'Tambah Kategori')

@section('card_header')
    <h3>Tambah Kategori Baru</h3>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
@stop

@section('card_body')
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_kategori">Nama Kategori:</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required placeholder="Contoh: Entertainment & Recreation, SAVINGS, dll.">
        </div>
        <button type="submit" class="btn btn-primary">Tambah Kategori</button>
    </form>
@endsection
