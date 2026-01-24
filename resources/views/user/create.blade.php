@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Tambah User Baru</h1>

    <div class="bg-white p-8 rounded-xl shadow-md max-w-2xl mx-auto">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            
            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="block text-slate-700 text-sm font-medium mb-2">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('username') border-red-500 @enderror"
                       required autofocus>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-slate-700 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('password') border-red-500 @enderror"
                       required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Role --}}
            <div class="mb-4">
                <label for="role" class="block text-slate-700 text-sm font-medium mb-2">Role</label>
                <select name="role" id="role" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('role') border-red-500 @enderror" required>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="pemilik">Pemilik</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('user.index') }}"
                   class="bg-white border border-slate-300 text-slate-700 font-medium py-2 px-4 rounded-lg hover:bg-slate-50 transition duration-300 ease-in-out">
                    Batal
                </a>
                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
@endsection
