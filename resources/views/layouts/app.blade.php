<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title', 'Admin Dashboard') - Kedai Bang Nana</title>
		@vite('resources/css/app.css')
		<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
	</head>

	<body class="bg-slate-50 text-slate-800">

		<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-100">
			<!-- Sidebar -->
			<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
				class="fixed inset-y-0 left-0 z-30 w-64 transform bg-white shadow-lg transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:shadow-none">

				<!-- Logo -->
				<div class="flex items-center justify-center border-b border-slate-200 px-6 py-4">
					<h2 class="text-2xl font-bold text-slate-800">
						Kedai Bang <span class="text-amber-500">Nana</span>
					</h2>
				</div>

				<!-- Nav Links -->
				<nav class="mt-4">
					<a href="{{ route('dashboard') }}"
						class="{{ request()->routeIs('dashboard') ? 'text-amber-600 bg-amber-50' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} flex items-center px-6 py-3">
						<!-- Heroicon: home -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
						</svg>
						<span class="mx-4 font-medium">Dashboard</span>
					</a>
					<a href="{{ route('menu.index') }}"
						class="{{ request()->routeIs('menu.*') ? 'text-amber-600 bg-amber-50' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} flex items-center px-6 py-3">
						<!-- Heroicon: document-text -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
						</svg>
						<span class="mx-4 font-medium">Menu</span>
					</a>
					<a href="{{ route('kategori.index') }}"
						class="{{ request()->routeIs('kategori.*') ? 'text-amber-600 bg-amber-50' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} flex items-center px-6 py-3">
						<!-- Heroicon: collection -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
						</svg>
						<span class="mx-4 font-medium">Kategori</span>
					</a>
					{{-- Admin-only links --}}
					@if (Auth::user()->role == 'admin')
						<a href="{{ route('user.index') }}"
							class="{{ request()->routeIs('user.*') ? 'text-amber-600 bg-amber-50' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} flex items-center px-6 py-3">
							<!-- Heroicon: users -->
							<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M15 19.128a9.38 9.38 0 0 0 2.625.372m-10.512a9.38 9.38 0 0 0 2.625.372M3 13.128c0-1.345.313-2.622.878-3.796C5.087 6.342 6.982 4.5 9 4.5c2.018 0 3.913 1.842 5.122 4.832M15 13.128c0-1.345-.313-2.622-.878-3.796C12.913 6.342 11.018 4.5 9 4.5c-2.018 0-3.913 1.842-5.122 4.832" />
							</svg>
							<span class="mx-4 font-medium">Users</span>
						</a>
					@endif
					<a href="{{ route('kasir.pesanan') }}"
						class="{{ request()->routeIs('kasir.*', 'order.*') ? 'text-amber-600 bg-amber-50' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900' }} flex items-center px-6 py-3">
						<!-- Heroicon: shopping-cart -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
						</svg>
						<span class="mx-4 font-medium">Pesanan</span>
					</a>

					<!-- Logout Form -->
					<form action="/logout" method="POST">
						@csrf
						<button type="submit"
							class="flex w-full items-center px-6 py-3 text-slate-700 hover:bg-slate-50 hover:text-slate-900">
							<!-- Heroicon: logout -->
							<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
							</svg>
							<span class="mx-4 font-medium">Keluar</span>
						</button>
					</form>
				</nav>
			</aside>

			<!-- Main content -->
			<div class="flex flex-1 flex-col overflow-hidden">
				<!-- Header -->
				<header class="flex items-center justify-between border-b border-slate-200 bg-white p-4">
					<!-- Mobile menu button -->
					<button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 focus:outline-none md:hidden">
						<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
						</svg>
					</button>

					<div class="flex-1 text-right">
						<span class="font-medium text-slate-700">Selamat Datang, {{ Auth::user()->username ?? 'Pengguna' }}</span>
					</div>
				</header>

				<!-- Page Content -->
				<main class="flex-1 overflow-y-auto overflow-x-hidden bg-slate-50">
					<div class="container mx-auto px-6 py-8">
						@yield('content')
					</div>
				</main>
			</div>
		</div>

	</body>

</html>
