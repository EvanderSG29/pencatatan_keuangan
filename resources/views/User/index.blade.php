@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('page_heading', 'Daftar Pengguna')

@section('card_header')
    <h3>Pengguna</h3>
    <a href="{{ route('home') }}" class="btn btn-default">Kembali</a>
@stop

@section('card_body')
    <div class="row">
        @auth
            <div class="col-md-6 offset-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex">
                        <div class="mr-3">
                            @if($user && $user->path_foto)
                                <img src="{{ asset('storage/' . $user->path_foto) }}" alt="{{ $user->name }}" class="img-thumbnail" style="width:96px;height:96px;object-fit:cover;">
                            @else
                                <img src="{{ asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" alt="no-photo" class="img-thumbnail" style="width:96px;height:96px;object-fit:cover;">
                            @endif
                        </div>
                        <div class="flex-fill">
                            <h5 class="mb-1">{{ $user->name ?? '—' }}</h5>
                            <p class="mb-1 text-muted">{{ $user->username ?? '' }}</p>
                            <p class="mb-1"><i class="fas fa-envelope"></i> {{ $user->email ?? '' }}</p>
                            @if(!empty($user->no_telp))
                                <p class="mb-1"><i class="fas fa-phone"></i> {{ $user->no_telp }}</p>
                            @endif
                            @if(!empty($user->lokasi) || !empty($user->jenis_kelamin) || !empty($user->tanggal_lahir))
                                <small class="text-muted">
                                    @if(!empty($user->lokasi)) <span class="mr-2"><i class="fas fa-map-marker-alt"></i> {{ $user->lokasi }}</span> @endif
                                    @if(!empty($user->jenis_kelamin)) <span class="mr-2"><i class="fas fa-user"></i> {{ $user->jenis_kelamin }}</span> @endif
                                    @if(!empty($user->tanggal_lahir)) <span><i class="fas fa-birthday-cake"></i> {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') }}</span> @endif
                                </small>
                            @endif
                        </div>
                    </div>
                    @if(!empty($user->alamat))
                        <div class="card-footer bg-white">
                            <small><i class="fas fa-home"></i> {{ $user->alamat }}</small>
                        </div>
                    @endif
                </div>
            </div>
        @endauth

        @guest
            <div class="col-12">
                <div class="alert alert-info">Silakan masuk untuk melihat profil Anda.</div>
            </div>
        @endguest
    </div>
@endsection

@section('js')
@endsection