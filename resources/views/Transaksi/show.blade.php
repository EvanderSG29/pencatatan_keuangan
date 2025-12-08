@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('page_heading', 'Detail Transaksi')

@section('card_header')
    <h3>Detail Transaksi</h3>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali ke Daftar Transaksi</a>
    <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning">Edit</a>
@stop

@section('card_body')
    <div class="row">
        <div class="col-md-6">
            <h5>Informasi Transaksi</h5>
            <table class="table table-bordered">
                <tr>
                    <th>ID Transaksi</th>
                    <td>{{ $transaksi->id_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Nama Transaksi</th>
                    <td>{{ $transaksi->nama_transaksi }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $transaksi->kategori->nama_kategori ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Jenis Transaksi</th>
                    <td>{{ $transaksi->jenis_transaksi }}</td>
                </tr>
                <tr>
                    <th>Nominal</th>
                    <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
