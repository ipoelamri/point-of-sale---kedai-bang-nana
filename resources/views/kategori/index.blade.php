@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<div>
			<h1 class="text-2xl font-bold text-white">Manajemen Kategori</h1>
			<p class="mt-1 text-sm text-slate-400">Kelola kategori menu kedai</p>
		</div>
		<a href="{{ route('kategori.create') }}" class="btn btn-primary">
			<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
			</svg>
			Tambah Kategori
		</a>
	</div>

	<div class="glass-card overflow-hidden rounded-2xl">
		<div class="overflow-x-auto">
			<table class="min-w-full">
				<thead>
					<tr class="border-b border-white/5">
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Kategori</th>
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Jumlah Menu</th>
						<th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-white/5">
					@forelse ($kategoris as $kategori)
						<tr class="transition-colors hover:bg-white/[0.02]">
							<td class="px-6 py-4 font-medium text-white">{{ $kategori->nama_kategori }}</td>
							<td class="px-6 py-4">
								<span class="badge badge-info">{{ $kategori->menus()->count() }} menu</span>
							</td>
							<td class="px-6 py-4 text-right">
								<div class="flex items-center justify-end gap-3">
									<a href="{{ route('kategori.edit', $kategori->id_kategori) }}"
										class="text-sm font-medium text-emerald-400 transition hover:text-emerald-300">Edit</a>
									<form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" class="inline-block"
										onsubmit="return confirm('Menghapus kategori akan menghapus semua menu di dalamnya. Apakah Anda yakin?');">
										@csrf
										@method('DELETE')
										<button type="submit" class="text-sm font-medium text-red-400 transition hover:text-red-300">Hapus</button>
									</form>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="py-12 text-center text-slate-500">
								Belum ada data kategori.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		{{-- Pagination Links --}}
		<div class="border-t border-white/5 px-6 py-4">
			{{ $kategoris->links() }}
		</div>
	</div>
@endsection
