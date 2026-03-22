@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
	<h1 class="mb-6 text-3xl font-bold text-white">Edit User</h1>

	<div class="mx-auto max-w-2xl rounded-xl border border-slate-700 bg-slate-900 p-8 shadow-md">
		<form action="{{ route('user.update', $user->id_user) }}" method="POST">
			@csrf
			@method('PUT')

			{{-- Username --}}
			<div class="mb-4">
				<label for="username" class="mb-2 block text-sm font-medium text-slate-300">Username</label>
				<input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
					class="@error('username') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-pink-500"
					required autofocus>
				@error('username')
					<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Password --}}
			<div class="mb-4">
				<label for="password" class="mb-2 block text-sm font-medium text-slate-300">Password (Opsional)</label>
				<input type="password" name="password" id="password"
					class="@error('password') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-pink-500">
				<p class="mt-1 text-xs text-slate-400">Kosongkan jika tidak ingin mengubah password.</p>
				@error('password')
					<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Role --}}
			<div class="mb-4">
				<label for="role" class="mb-2 block text-sm font-medium text-slate-300">Role</label>
				<select name="role" id="role"
					class="@error('role') border-red-500 @enderror w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-pink-500"
					required>
					<option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
					<option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
					<option value="pemilik" {{ old('role', 'pemilik') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
				</select>
				@error('role')
					<p class="mt-1 text-xs text-red-400">{{ $message }}</p>
				@enderror
			</div>

			{{-- Tombol Aksi --}}
			<div class="mt-6 flex justify-end gap-4">
				<a href="{{ route('user.index') }}"
					class="rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 font-medium text-slate-300 transition duration-300 ease-in-out hover:bg-slate-700">
					Batal
				</a>
				<button type="submit" class="rounded-lg px-4 py-2 font-medium text-white transition duration-300 ease-in-out"
					style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
		</form>
	</div>
@endsection
