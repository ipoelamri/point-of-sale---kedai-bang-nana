@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
	<h1 class="mb-6 text-3xl font-bold text-white">Tambah Menu Baru</h1>

	<div class="rounded-xl border border-slate-700 bg-slate-900 p-8 shadow-md">
		<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="grid grid-cols-1 gap-6 md:grid-cols-2">

				{{-- Nama Menu --}}
				<div class="mb-4">
					<label for="nama_menu" class="mb-2 block text-sm font-medium text-slate-300">Nama Menu</label>
					<input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu') }}"
						class="@error('nama_menu') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
						required>
					@error('nama_menu')
						<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Kategori --}}
				<div class="mb-4">
					<label for="kategori_id" class="mb-2 block text-sm font-medium text-slate-300">Kategori</label>
					<select name="kategori_id" id="kategori_id"
						class="@error('kategori_id') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
						required>
						<option value="">Pilih Kategori</option>
						@foreach ($kategoris as $kategori)
							<option value="{{ $kategori->id_kategori }}" {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
								{{ $kategori->nama_kategori }}
							</option>
						@endforeach
					</select>
					@error('kategori_id')
						<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Harga --}}
				<div class="mb-4">
					<label for="harga" class="mb-2 block text-sm font-medium text-slate-300">Harga</label>
					<input type="number" name="harga" id="harga" value="{{ old('harga') }}"
						class="@error('harga') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500"
						required min="0">
					@error('harga')
						<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
					@enderror
				</div>

				{{-- Stok --}}
				<div class="mb-4">
					<label for="stok" class="mb-2 block text-sm font-medium text-slate-700">Stok</label>
					<input type="number" name="stok" id="stok" value="{{ old('stok') }}"
						class="@error('stok') border-red-500 @enderror w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500"
						required min="0">
					@error('stok')
						<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
					@enderror
				</div>

				{{-- Deskripsi --}}
				<div class="mb-4 md:col-span-2">
					<label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</label>
					<textarea name="deskripsi" id="deskripsi" rows="4"
					 class="@error('deskripsi') border-red-500 @enderror w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('deskripsi') }}</textarea>
					@error('deskripsi')
						<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
					@enderror
				</div>

				{{-- Foto --}}
				<div class="mb-4 md:col-span-2">
					<label for="foto" class="mb-2 block text-sm font-medium text-slate-700">Foto Menu</label>
					<input type="file" name="foto" id="foto" accept="image/*"
						class="@error('foto') border-red-500 @enderror w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-amber-700 hover:file:bg-amber-100">
					@error('foto')
						<p class="mt-1 text-xs text-red-500">{{ $message }}</p>
					@enderror
				</div>

			</div>

			{{-- Tombol Aksi --}}
			<div class="mt-6 flex justify-end gap-4">
				<a href="{{ route('menu.index') }}"
					class="rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 font-medium text-slate-300 transition duration-300 ease-in-out hover:bg-slate-700">
					Batal
				</a>
				<button type="submit"
					class="rounded-lg bg-amber-500 px-4 py-2 font-medium text-white transition duration-300 ease-in-out hover:bg-amber-600">
					Simpan Menu
				</button>
			</div>
		</form>
	</div>
@endsection
