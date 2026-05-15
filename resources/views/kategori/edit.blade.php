@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
	<div class="mb-6">
		<h1 class="text-2xl font-bold text-white">Edit Kategori</h1>
		<p class="mt-1 text-sm text-slate-400">{{ $kategori->nama_kategori }}</p>
	</div>

	<div class="mx-auto max-w-2xl glass-card rounded-2xl p-6 sm:p-8">
		<form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
			@csrf
			@method('PUT')

			{{-- Nama Kategori --}}
			<div class="mb-5">
				<label for="nama_kategori" class="form-label">Nama Kategori</label>
				<input type="text" name="nama_kategori" id="nama_kategori"
					value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
					class="form-input @error('nama_kategori') !border-red-500/50 @enderror"
					required autofocus>
				@error('nama_kategori')
					<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Tombol Aksi --}}
			<div class="mt-8 flex justify-end gap-3">
				<a href="{{ route('kategori.index') }}" class="btn btn-ghost">
					Batal
				</a>
				<button type="submit" class="btn btn-primary">
					Simpan Perubahan
				</button>
			</div>
		</form>
	</div>
@endsection
