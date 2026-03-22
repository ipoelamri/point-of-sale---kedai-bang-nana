@extends('layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
	<h1 class="mb-6 text-3xl font-bold text-white">Tambah Kategori Baru</h1>

	<div class="mx-auto max-w-2xl rounded-xl border border-slate-700 bg-slate-900 p-8 shadow-md">
		<form action="{{ route('kategori.store') }}" method="POST">
			@csrf

			{{-- Nama Kategori --}}
			<div class="mb-4">
				<label for="nama_kategori" class="mb-2 block text-sm font-medium text-slate-300">Nama Kategori</label>
				<input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}"
					class="@error('nama_kategori') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
					required autofocus>
				@error('nama_kategori')
					<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Tombol Aksi --}}
			<div class="mt-6 flex justify-end gap-4">
				<a href="{{ route('kategori.index') }}"
					class="rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 font-medium text-slate-300 transition duration-300 ease-in-out hover:bg-slate-700">
					Batal
				</a>
				<button type="submit" class="rounded-lg px-4 py-2 font-medium text-white transition duration-300 ease-in-out"
					style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
					Simpan Kategori
				</button>
			</div>
		</form>
	</div>
@endsection
