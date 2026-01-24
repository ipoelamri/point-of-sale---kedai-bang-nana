@extends('layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Tambah Kategori Baru</h1>

    <div class="bg-white p-8 rounded-xl shadow-md max-w-2xl mx-auto">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            
            {{-- Nama Kategori --}}
            <div class="mb-4">
                <label for="nama_kategori" class="block text-slate-700 text-sm font-medium mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('nama_kategori') border-red-500 @enderror"
                       required autofocus>
                @error('nama_kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('kategori.index') }}"
                   class="bg-white border border-slate-300 text-slate-700 font-medium py-2 px-4 rounded-lg hover:bg-slate-50 transition duration-300 ease-in-out">
                    Batal
                </a>
                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
@endsection
