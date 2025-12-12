@if($data->count())
<table class="table table-hover table-sm mb-0">
    <thead class="bg-light">
        <tr>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $t)
            <tr>
                <td>{{ $t->nama_transaksi }}</td>
                <td>{{ $t->kategori->nama_kategori ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $t->jenis_transaksi == 'Pemasukan' ? 'success' : 'danger' }}">
                        {{ $t->jenis_transaksi }}
                    </span>
                </td>
                <td>Rp {{ number_format($t->nominal,0,',','.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="p-3 text-muted">Belum ada transaksi.</div>
@endif
