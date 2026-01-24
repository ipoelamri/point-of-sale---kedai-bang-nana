@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Tambah Menu Baru</h1>

    <div class="bg-white p-8 rounded-xl shadow-md">
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Nama Menu --}}
                <div class="mb-4">
                    <label for="nama_menu" class="block text-slate-700 text-sm font-medium mb-2">Nama Menu</label>
                    <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('nama_menu') border-red-500 @enderror"
                           required>
                    @error('nama_menu')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="mb-4">
                    <label for="kategori_id" class="block text-slate-700 text-sm font-medium mb-2">Kategori</label>
                    <select name="kategori_id" id="kategori_id" 
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('kategori_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ old('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label for="harga" class="block text-slate-700 text-sm font-medium mb-2">Harga</label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('harga') border-red-500 @enderror"
                           required min="0">
                    @error('harga')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="mb-4">
                    <label for="stok" class="block text-slate-700 text-sm font-medium mb-2">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('stok') border-red-500 @enderror"
                           required min="0">
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Deskripsi --}}
                <div class="mb-4 md:col-span-2">
                    <label for="deskripsi" class="block text-slate-700 text-sm font-medium mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('deskripsi') border-red-500 @enderror"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="mb-4 md:col-span-2">
                    <label for="foto" class="block text-slate-700 text-sm font-medium mb-2">Foto Menu</label>
                    <input type="file" name="foto" id="foto" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 @error('foto') border-red-500 @enderror">
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-end gap-4">
                <a href="{{ route('menu.index') }}"
                   class="bg-white border border-slate-300 text-slate-700 font-medium py-2 px-4 rounded-lg hover:bg-slate-50 transition duration-300 ease-in-out">
                    Batal
                </a>
                <button type="submit"
                        class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>
@endsection
