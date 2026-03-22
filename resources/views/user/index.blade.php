@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<h1 class="text-3xl font-bold text-white">Manajemen User</h1>
		<a href="{{ route('user.create') }}"
			class="rounded-lg px-4 py-2 font-medium text-white transition duration-300 ease-in-out"
			style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
			+ Tambah User
		</a>
	</div>

	<div class="rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-md">
		<div class="overflow-x-auto">
			<table class="min-w-full">
				<thead class="bg-slate-800">
					<tr>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-300">Username</th>
						<th class="px-6 py-3 text-left text-sm font-medium text-slate-300">Role</th>
						<th class="px-6 py-3 text-right text-sm font-medium text-slate-300">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($users as $user)
						<tr class="border-b border-slate-700 hover:bg-slate-800">
							<td class="px-6 py-4 font-medium text-white">{{ $user->username }}</td>
							<td class="px-6 py-4 text-slate-300">{{ $user->role }}</td>
							<td class="px-6 py-4 text-right">
								<a href="{{ route('user.edit', $user->id_user) }}" class="font-medium text-pink-400 hover:text-pink-300">Edit</a>
								<form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="ml-4 inline-block"
									onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="font-medium text-red-400 hover:text-red-300">Hapus</button>
								</form>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="py-8 text-center text-slate-400">
								Belum ada data user.
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		{{-- Pagination Links --}}
		<div class="mt-6">
			{{ $users->links() }}
		</div>
	</div>
@endsection
