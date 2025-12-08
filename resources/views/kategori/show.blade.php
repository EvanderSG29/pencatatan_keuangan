@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('page_heading', 'Detail Kategori')

@section('card_header')
    <h3>Detail Kategori</h3>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
    <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-warning">Edit</a>
@stop

@section('card_body')
    <div class="row">
        <div class="col-md-6">
            <h5>Informasi Kategori</h5>
            <table class="table table-bordered">
                <tr>
                    <th>ID Kategori</th>
                    <td>{{ $kategori->id_kategori }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori</th>
                    <td>{{ $kategori->nama_kategori }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
