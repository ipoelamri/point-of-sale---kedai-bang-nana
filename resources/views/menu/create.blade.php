@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
	<div class="mb-6">
		<h1 class="text-2xl font-bold text-white">Tambah Menu Baru</h1>
		<p class="mt-1 text-sm text-slate-400">Isi detail menu yang akan ditambahkan</p>
	</div>

	<div class="glass-card rounded-2xl p-6 sm:p-8">
		<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

				{{-- Nama Menu --}}
				<div>
					<label for="nama_menu" class="form-label">Nama Menu</label>
					<input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu') }}"
						class="form-input @error('nama_menu') !border-red-500/50 @enderror"
						required>
					@error('nama_menu')
						<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Kategori --}}
				<div>
					<label for="kategori_id" class="form-label">Kategori</label>
					<select name="kategori_id" id="kategori_id"
						class="form-input @error('kategori_id') !border-red-500/50 @enderror"
						required>
						<option value="">Pilih Kategori</option>
						@foreach ($kategoris as $kategori)
							<option value="{{ $kategori->id_kategori }}" {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
								{{ $kategori->nama_kategori }}
							</option>
						@endforeach
					</select>
					@error('kategori_id')
						<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Harga --}}
				<div>
					<label for="harga" class="form-label">Harga</label>
					<input type="number" name="harga" id="harga" value="{{ old('harga') }}"
						class="form-input @error('harga') !border-red-500/50 @enderror"
						required min="0">
					@error('harga')
						<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Stok --}}
				<div>
					<label for="stok" class="form-label">Stok</label>
					<input type="number" name="stok" id="stok" value="{{ old('stok') }}"
						class="form-input @error('stok') !border-red-500/50 @enderror"
						required min="0">
					@error('stok')
						<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Deskripsi --}}
				<div class="md:col-span-2">
					<label for="deskripsi" class="form-label">Deskripsi</label>
					<textarea name="deskripsi" id="deskripsi" rows="4"
					 class="form-input @error('deskripsi') !border-red-500/50 @enderror">{{ old('deskripsi') }}</textarea>
					@error('deskripsi')
						<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Foto --}}
				<div class="md:col-span-2">
					<label for="foto" class="form-label">Foto Menu</label>
					<input type="file" name="foto" id="foto" accept="image/*"
						class="w-full text-sm text-slate-400 file:mr-4 file:rounded-xl file:border-0 file:bg-pink-500/10 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-pink-400 hover:file:bg-pink-500/20 @error('foto') text-red-400 @enderror">
					@error('foto')
						<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

			</div>

			{{-- Tombol Aksi --}}
			<div class="mt-8 flex justify-end gap-3">
				<a href="{{ route('menu.index') }}" class="btn btn-ghost">
					Batal
				</a>
				<button type="submit" class="btn btn-secondary">
					Simpan Menu
				</button>
			</div>
		</form>
	</div>
@endsection
