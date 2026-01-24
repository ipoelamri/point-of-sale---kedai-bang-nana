@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-slate-800">Manajemen User</h1>
        <a href="{{ route('user.create') }}"
           class="bg-amber-500 hover:bg-amber-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300 ease-in-out">
            + Tambah User
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-medium text-slate-600">Username</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-slate-600">Role</th>
                        <th class="py-3 px-6 text-right text-sm font-medium text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-slate-200 hover:bg-slate-50">
                            <td class="py-4 px-6 font-medium text-slate-900">{{ $user->username }}</td>
                            <td class="py-4 px-6 text-slate-700">{{ $user->role }}</td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('user.edit', $user->id_user) }}" class="text-amber-600 hover:text-amber-800 font-medium">Edit</a>
                                <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-slate-500">
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
