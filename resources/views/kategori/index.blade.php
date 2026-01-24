@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Manajemen Kategori</h1>
        <a href="{{ route('kategori.create') }}"
           class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300 ease-in-out">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-slate-600">Nama Kategori</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-slate-600">Jumlah Menu</th>
                        <th class="py-3 px-6 text-right text-sm font-medium text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                        <tr class="border-b border-slate-200 hover:bg-slate-50">
                            <td class="py-4 px-6 font-medium text-slate-900">{{ $kategori->nama_kategori }}</td>
                            <td class="py-4 px-6 text-slate-700">{{ $kategori->menus()->count() }}</td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('kategori.edit', $kategori->id_kategori) }}" class="text-amber-600 hover:text-amber-800 font-medium">Edit</a>
                                <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Menghapus kategori akan menghapus semua menu di dalamnya. Apakah Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-slate-500">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Links --}}
        <div class="mt-6">
            {{ $kategoris->links() }}
        </div>
    </div>
@endsection
