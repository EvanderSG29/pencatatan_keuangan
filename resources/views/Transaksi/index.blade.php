@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('page_heading', 'Daftar Transaksi')

@section('card_header')
    <h3>Daftar Transaksi</h3>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
@stop

@section('card_body')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nama Transaksi</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Qty</th>
                <th>Nominal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->id_transaksi }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ $transaksi->nama_transaksi }}</td>
                    <td>{{ $transaksi->kategori->nama_kategori ?? 'N/A' }}</td>
                    <td>{{ $transaksi->jenis_transaksi }}</td>
                    <td>{{ $transaksi->qty }}</td>
                    <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
