@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<div>
			<h1 class="text-2xl font-bold text-white">Manajemen User</h1>
			<p class="mt-1 text-sm text-slate-400">Kelola akun pengguna sistem</p>
		</div>
		<a href="{{ route('user.create') }}" class="btn btn-primary">
			<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
			</svg>
			Tambah User
		</a>
	</div>

	<div class="glass-card overflow-hidden rounded-2xl">
		<div class="overflow-x-auto">
			<table class="min-w-full">
				<thead>
					<tr class="border-b border-white/5">
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Username</th>
						<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Role</th>
						<th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-white/5">
					@forelse ($users as $user)
						<tr class="transition-colors hover:bg-white/[0.02]">
							<td class="px-6 py-4">
								<div class="flex items-center gap-3">
									<div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-pink-500 to-violet-500 text-xs font-bold text-white">
										{{ strtoupper(substr($user->username, 0, 1)) }}
									</div>
									<span class="font-medium text-white">{{ $user->username }}</span>
								</div>
							</td>
							<td class="px-6 py-4">
								<span class="badge
									@if($user->role === 'admin') badge-danger
									@elseif($user->role === 'kasir') badge-info
									@else badge-success @endif">
									{{ ucfirst($user->role) }}
								</span>
							</td>
							<td class="px-6 py-4 text-right">
								<div class="flex items-center justify-end gap-3">
									<a href="{{ route('user.edit', $user->id_user) }}" class="text-sm font-medium text-pink-400 transition hover:text-pink-300">Edit</a>
									<form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="inline-block"
										onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
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
								Belum ada data user.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		{{-- Pagination Links --}}
		<div class="border-t border-white/5 px-6 py-4">
			{{ $users->links() }}
		</div>
	</div>
@endsection
