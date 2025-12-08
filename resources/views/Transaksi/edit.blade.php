@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('page_heading', 'Edit Transaksi')

@section('card_header')
    <h3>Edit Transaksi</h3>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
@stop

@section('card_body')
    <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="tanggal_transaksi">Tanggal Transaksi:</label>
            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi }}" required>
        </div>
        <div class="form-group">
            <label for="nama_transaksi">Nama Transaksi:</label>
            <input type="text" class="form-control" id="nama_transaksi" name="nama_transaksi" value="{{ $transaksi->nama_transaksi }}" required>
        </div>
        <div class="form-group">
            <label for="id_kategori">Kategori:</label>
            <select class="form-control" id="id_kategori" name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ $transaksi->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jenis_transaksi">Jenis Transaksi:</label>
            <select class="form-control" id="jenis_transaksi" name="jenis_transaksi" required>
                <option value="Pemasukan" {{ $transaksi->jenis_transaksi == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="Pengeluaran" {{ $transaksi->jenis_transaksi == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div class="form-group">
            <label for="nominal">Nominal:</label>
            <input type="number" class="form-control" id="nominal" name="nominal" value="{{ $transaksi->nominal }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Transaksi</button>
    </form>
@endsection
