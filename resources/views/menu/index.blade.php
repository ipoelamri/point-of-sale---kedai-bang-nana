@extends('layouts.app')

@section('title', 'Manajemen Menu')

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<div>
			<h1 class="text-2xl font-bold text-white">Manajemen Menu</h1>
			<p class="mt-1 text-sm text-slate-400">Kelola semua item menu kedai</p>
		</div>
		<a href="{{ route('menu.create') }}" class="btn btn-secondary">
			<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
			</svg>
			Tambah Menu
		</a>
	</div>

	<div class="glass-card overflow-hidden rounded-2xl">
		<div class="overflow-x-auto">
			<table class="min-w-full">
				<thead>
					<tr class="border-b border-white/5">
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Foto</th>
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Menu</th>
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</th>
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Harga</th>
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Status</th>
						<th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-white/5">
					@forelse ($menus as $menu)
						<tr class="transition-colors hover:bg-white/[0.02]">
							<td class="px-6 py-4">
								@php
									$storagePath = public_path('storage/' . $menu->foto);
									$uploadsPath = public_path('uploads/' . $menu->foto);
									if (file_exists($storagePath)) {
									    $src = asset('storage/' . $menu->foto);
									} elseif (file_exists($uploadsPath)) {
									    $src = asset('uploads/' . $menu->foto);
									} else {
									    $src = asset('storage/fotos/default.jpg');
									}
								@endphp
								<img src="{{ $src }}" alt="{{ $menu->nama_menu }}" class="h-12 w-12 rounded-xl object-cover ring-1 ring-white/10">
							</td>
							<td class="px-6 py-4 font-medium text-white">{{ $menu->nama_menu }}</td>
							<td class="px-6 py-4 text-slate-300">{{ $menu->kategori->nama_kategori }}</td>
							<td class="px-6 py-4 font-medium text-slate-200">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
							<td class="px-6 py-4">
								@if ($menu->is_available)
									<span class="badge badge-success">Tersedia</span>
								@else
									<span class="badge badge-danger">Habis</span>
								@endif
							</td>
							<td class="px-6 py-4 text-right">
								<div class="flex items-center justify-end gap-3">
									<a href="{{ route('menu.edit', $menu->id_menu) }}"
										class="text-sm font-medium text-amber-400 transition hover:text-amber-300">Edit</a>
									<form action="{{ route('menu.destroy', $menu->id_menu) }}" method="POST" class="inline-block"
										onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
										@csrf
										@method('DELETE')
										<button type="submit" class="text-sm font-medium text-red-400 transition hover:text-red-300">Hapus</button>
									</form>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="py-12 text-center text-slate-500">
								Belum ada data menu.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		{{-- Pagination Links --}}
		<div class="border-t border-white/5 px-6 py-4">
			{{ $menus->links() }}
		</div>
	</div>
@endsection
