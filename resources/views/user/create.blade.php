@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
	<div class="mb-6">
		<h1 class="text-2xl font-bold text-white">Tambah User Baru</h1>
		<p class="mt-1 text-sm text-slate-400">Buat akun pengguna baru</p>
	</div>

	<div class="mx-auto max-w-2xl glass-card rounded-2xl p-6 sm:p-8">
		<form action="{{ route('user.store') }}" method="POST">
			@csrf

			{{-- Username --}}
			<div class="mb-5">
				<label for="username" class="form-label">Username</label>
				<input type="text" name="username" id="username" value="{{ old('username') }}"
					class="form-input @error('username') !border-red-500/50 @enderror"
					required autofocus>
				@error('username')
					<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Password --}}
			<div class="mb-5">
				<label for="password" class="form-label">Password</label>
				<input type="password" name="password" id="password"
					class="form-input @error('password') !border-red-500/50 @enderror"
					required>
				@error('password')
					<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Role --}}
			<div class="mb-5">
				<label for="role" class="form-label">Role</label>
				<select name="role" id="role"
					class="form-input @error('role') !border-red-500/50 @enderror"
					required>
					<option value="admin">Admin</option>
					<option value="kasir">Kasir</option>
					<option value="pemilik">Pemilik</option>
				</select>
				@error('role')
					<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Tombol Aksi --}}
			<div class="mt-8 flex justify-end gap-3">
				<a href="{{ route('user.index') }}" class="btn btn-ghost">
					Batal
				</a>
				<button type="submit" class="btn btn-primary">
					Simpan User
				</button>
			</div>
		</form>
	</div>
@endsection
