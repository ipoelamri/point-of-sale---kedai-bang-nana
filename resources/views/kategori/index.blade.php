@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<h1 class="text-3xl font-bold text-white">Manajemen Kategori</h1>
		<a href="{{ route('kategori.create') }}"
			class="rounded-lg px-4 py-2 font-medium text-white transition duration-300 ease-in-out"
			style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
			+ Tambah Kategori
		</a>
	</div>

	<div class="rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-md">
		<div class="overflow-x-auto">
			<table class="min-w-full">
				<thead class="bg-slate-800">
					<tr>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-300">Nama Kategori</th>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-300">Jumlah Menu</th>
						<th class="px-6 py-3 text-right text-sm font-medium text-slate-300">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($kategoris as $kategori)
						<tr class="border-b border-slate-700 hover:bg-slate-800">
							<td class="px-6 py-4 font-medium text-white">{{ $kategori->nama_kategori }}</td>
							<td class="px-6 py-4 text-slate-300">{{ $kategori->menus()->count() }}</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ route('kategori.edit', $kategori->id_kategori) }}"
									class="font-medium text-emerald-400 hover:text-emerald-300">Edit</a>
								<form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" class="ml-4 inline-block"
									onsubmit="return confirm('Menghapus kategori akan menghapus semua menu di dalamnya. Apakah Anda yakin?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="font-medium text-red-400 hover:text-red-300">Hapus</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="py-8 text-center text-slate-400">
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
