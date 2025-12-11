@extends('layouts.app')

@section('title', 'Edit Profil Pengguna')

@section('page_heading', 'Edit Profil Pengguna')

@section('card_header')
    <h4 class="m-0">Edit Profil</h4>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
@stop

@section('card_body')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Ada kesalahan:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        {{-- Foto Profil --}}
                        <div class="form-group text-center mb-4">
                            <label for="path_foto" class="form-label"><strong>Foto Profil</strong></label>
                            <div class="mb-3">
                                @if($user->path_foto)
                                    <img src="{{ asset('storage/' . $user->path_foto) }}" 
                                        alt="{{ $user->name }}" 
                                        class="rounded-circle shadow-sm"
                                        style="width:100px;height:100px;object-fit:cover;">
                                @else
                                    <img src="{{ asset('storage/users/profil.png') }}" 
                                        alt="default-profile" 
                                        class="rounded-circle shadow-sm"
                                        style="width:100px;height:100px;object-fit:cover;">
                                @endif
                            </div>
                            <input type="file" class="form-control @error('path_foto') is-invalid @enderror" 
                                id="path_foto" name="path_foto" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG (Max 2MB)</small>
                            @error('path_foto')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="form-group mb-3">
                            <label for="name" class="form-label"><strong>Nama Lengkap</strong></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $user->name) }}" 
                                placeholder="Masukkan nama lengkap Anda">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="form-group mb-3">
                            <label for="username" class="form-label"><strong>Username</strong></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username', $user->username) }}" 
                                placeholder="Masukkan username Anda" disabled>
                            <small class="form-text text-muted">Username tidak dapat diubah</small>
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email" class="form-label"><strong>Email</strong></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $user->email) }}" 
                                placeholder="Masukkan email Anda" disabled>
                            <small class="form-text text-muted">Email tidak dapat diubah</small>
                        </div>

                        {{-- Nomor Telepon --}}
                        <div class="form-group mb-3">
                            <label for="no_telp" class="form-label"><strong>Nomor Telepon</strong></label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                                id="no_telp" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" 
                                placeholder="Masukkan nomor telepon">
                            @error('no_telp')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div class="form-group mb-3">
                            <label for="lokasi" class="form-label"><strong>Lokasi</strong></label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                id="lokasi" name="lokasi" value="{{ old('lokasi', $user->lokasi) }}" 
                                placeholder="Masukkan lokasi Anda (Kota, Provinsi)">
                            @error('lokasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin" class="form-label"><strong>Jenis Kelamin</strong></label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir" class="form-label"><strong>Tanggal Lahir</strong></label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                id="tanggal_lahir" name="tanggal_lahir" 
                                value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                            @error('tanggal_lahir')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group mb-3">
                            <label for="alamat" class="form-label"><strong>Alamat</strong></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" name="alamat" rows="3" 
                                placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer bg-light">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Optional: Preview image before upload
        document.getElementById('path_foto').addEventListener('change', function(e){
            const file = e.target.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(event){
                    const img = document.querySelector('img[alt="{{ $user->name }}"], img[alt="no-photo"]');
                    if(img) img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
