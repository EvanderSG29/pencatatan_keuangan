@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('page_heading', 'Daftar Transaksi')

@section('card_header')
    <h3>Daftar Transaksi</h3>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Transaksi
    </a>
@stop

@section('card_body')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="thead-light">
            <tr>
                <th>Tanggal</th>
                <th>Nama Transaksi</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Qty</th>
                <th>Nominal</th>
                <th>Total</th> 
                <th class="text-center" style="width: 60px;"></th>
            </tr>
        </thead>

        <tbody>
        @foreach($transaksis as $transaksi)
        <tr>
            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y') }}</td>
            <td>{{ $transaksi->nama_transaksi }}</td>
            <td>{{ $transaksi->kategori->nama_kategori ?? 'N/A' }}</td>

            <td>
                @if(strtolower($transaksi->jenis_transaksi) === 'pemasukan')
                    <span class="badge badge-success">Pemasukan</span>
                @else
                    <span class="badge badge-danger">Pengeluaran</span>
                @endif
            </td>

            <td>{{ $transaksi->qty }}</td>

            <td>Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>

            <td>Rp {{ number_format($transaksi->qty * $transaksi->nominal, 0, ',', '.') }}</td> {{-- Kolom total baru --}}

            <td class="text-center">
                <div class="dropdown">
                    <a href="#" class="text-secondary" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v fa-lg"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('transaksi.edit', $transaksi) }}">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>

                        <a class="dropdown-item text-danger delete-transaksi-link" href="#" data-id="{{ $transaksi->id_transaksi }}">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                        </a>

                        <form id="delete-form-{{ $transaksi->id_transaksi }}"
                            action="{{ route('transaksi.destroy', $transaksi) }}"
                            method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>


    </table>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteLinks = document.querySelectorAll('.delete-transaksi-link');

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                const confirmDelete = confirm('Apakah Anda yakin ingin menghapus transaksi ini?');

                if (confirmDelete) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush
