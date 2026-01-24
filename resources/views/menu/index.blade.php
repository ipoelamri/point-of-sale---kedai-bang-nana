@extends('layouts.app')

@section('title', 'Manajemen Menu')

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<h1 class="text-3xl font-bold text-slate-800">Manajemen Menu</h1>
		<a href="{{ route('menu.create') }}"
			class="rounded-lg bg-amber-500 px-4 py-2 font-medium text-white transition duration-300 ease-in-out hover:bg-amber-600">
			+ Tambah Menu
		</a>
	</div>

	<div class="rounded-xl bg-white p-6 shadow-md">
		<div class="overflow-x-auto">
			<table class="min-w-full">
				<thead class="bg-slate-50">
					<tr>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-600">Foto</th>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-600">Nama Menu</th>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-600">Kategori</th>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-600">Harga</th>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-600">Status</th>
						<th class="px-6 py-3 text-right text-sm font-medium text-slate-600">Aksi</th>
					</tr>
				</thead>
				<tbody>
					{{-- Data akan di-loop di sini --}}
					@forelse ($menus as $menu)
						<tr class="border-b border-slate-200 hover:bg-slate-50">
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
								<img src="{{ $src }}" alt="{{ $menu->nama_menu }}" class="h-12 w-12 rounded-md object-cover">
							</td>
							<td class="px-6 py-4 font-medium text-slate-900">{{ $menu->nama_menu }}</td>
							<td class="px-6 py-4 text-slate-700">{{ $menu->kategori->nama_kategori }}</td>
							<td class="px-6 py-4 text-slate-700">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
							<td class="px-6 py-4">
								@if ($menu->is_available)
									<span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800">Tersedia</span>
								@else
									<span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800">Habis</span>
								@endif
							</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ route('menu.edit', $menu->id_menu) }}"
									class="font-medium text-amber-600 hover:text-amber-800">Edit</a>
								<form action="{{ route('menu.destroy', $menu->id_menu) }}" method="POST" class="ml-4 inline-block"
									onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="font-medium text-red-600 hover:text-red-800">Hapus</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="py-8 text-center text-slate-500">
								Belum ada data menu.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		{{-- Pagination Links --}}
		<div class="mt-6">
			{{ $menus->links() }}
		</div>
	</div>
@endsection
