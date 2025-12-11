@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('page_heading', 'Profil Pengguna')

@section('card_header')
    <h4 class="m-0">Profil</h4>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">Edit</a>
@stop

@section('card_body')
    <div class="row justify-content-center">
        @auth
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">

                        {{-- Foto profil --}}
                        <div class="mb-3">
                            @if($user && $user->path_foto)
                                <img src="{{ asset('storage/' . $user->path_foto) }}" 
                                    alt="{{ $user->name }}" 
                                    class="rounded-circle shadow-sm"
                                    style="width:110px;height:110px;object-fit:cover;">
                            @else
                                <img src="{{ asset('storage/users/profil.png') }}" 
                                    alt="default-profile" 
                                    class="rounded-circle shadow-sm"    
                                    style="width:110px;height:110px;object-fit:cover;">
                            @endif
                        </div>

                        {{-- Nama --}}
                        <h4 class="mb-0">{{ $user->name ?? '—' }}</h4>
                        <p class="text-muted mb-2">{{ $user->username ?? '' }}</p>

                        {{-- Informasi kontak --}}
                        <div class="text-left px-4 mt-3">
                            <p class="mb-2"><i class="fas fa-envelope text-secondary"></i> {{ $user->email ?? '(Email kosong)' }}</p>

                            <p class="mb-2"><i class="fas fa-phone text-secondary"></i> {{ $user->no_telp ?? '(Nomor telepon belum ditambahkan)' }}</p>

                            <p class="mb-2"><i class="fas fa-map-marker-alt text-secondary"></i> {{ $user->lokasi ?? '(Lokasi belum ditambahkan)' }}</p>

                            <p class="mb-2"><i class="fas fa-user text-secondary"></i> {{ ($user->jenis_kelamin ? ucfirst($user->jenis_kelamin) : '(Jenis kelamin belum ditambahkan)') }}</p>

                            <p class="mb-2"><i class="fas fa-birthday-cake text-secondary"></i> 
                                @if($user->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') }}
                                @else
                                    (Tanggal lahir belum ditambahkan)
                                @endif
                            </p>

                            <p class="mb-2"><i class="fas fa-home text-secondary"></i> {{ $user->alamat ?? '(Alamat belum ditambahkan)' }}</p>
                        </div>

                    </div>
                </div>
            </div>
        @endauth

        @guest
            <div class="col-12">
                <div class="alert alert-info">Silakan masuk untuk melihat profil Anda.</div>
            </div>
        @endguest
    </div>
@stop
