@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('page_heading', 'Tambah Transaksi')

@section('card_header')
    <h3>Tambah Transaksi Baru</h3>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
@stop

@section('card_body')
    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tanggal_transaksi">Tanggal Transaksi:</label>
            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
        </div>
        <div class="form-group">
            <label for="nama_transaksi">Nama Transaksi:</label>
            <input type="text" class="form-control" id="nama_transaksi" name="nama_transaksi" required>
        </div>
        <div class="form-group">
            <label for="id_kategori">Kategori:</label>
            <select class="form-control" id="id_kategori" name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jenis_transaksi">Jenis Transaksi:</label>
            <select class="form-control" id="jenis_transaksi" name="jenis_transaksi" required>
                <option value="">Pilih Jenis</option>
                <option value="Pemasukan">Pemasukan</option>
                <option value="Pengeluaran">Pengeluaran</option>
            </select>
        </div>
        <div class="form-group">
            <label for="nominal">Nominal:</label>
            <input type="number" class="form-control" id="nominal" name="nominal" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
    </form>
@endsection
