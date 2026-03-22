<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title', 'Admin Dashboard') - Kedai Bang Nana</title>
		@vite('resources/css/app.css')
		<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
	</head>

	<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">

		<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-900">
			<!-- Sidebar -->
			<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
				class="fixed inset-y-0 left-0 z-30 w-64 transform bg-slate-900 shadow-lg transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:shadow-none">

				<!-- Logo -->
				<div class="flex items-center justify-center border-b border-slate-700 px-6 py-4">
					<h2 class="text-2xl font-bold text-white">
						Kedai Bang <span
							style="background: linear-gradient(135deg, #ff1493 0%, #d90b84 100%); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Nana</span>
					</h2>
				</div>

				<!-- Nav Links -->
				<nav class="mt-4">
					<a href="{{ route('dashboard') }}"
						class="{{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} flex items-center px-6 py-3"
						style="{{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, #ff1493 0%, #d90b84 100%);' : '' }}">
						<!-- Heroicon: home -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
						</svg>
						<span class="mx-4 font-medium">Dashboard</span>
					</a>
					<a href="{{ route('menu.index') }}"
						class="{{ request()->routeIs('menu.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} flex items-center px-6 py-3"
						style="{{ request()->routeIs('menu.*') ? 'background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);' : '' }}">
						<!-- Heroicon: document-text -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
						</svg>
						<span class="mx-4 font-medium">Menu</span>
					</a>
					<a href="{{ route('kategori.index') }}"
						class="{{ request()->routeIs('kategori.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} flex items-center px-6 py-3"
						style="{{ request()->routeIs('kategori.*') ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);' : '' }}">
						<!-- Heroicon: collection -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
						</svg>
						<span class="mx-4 font-medium">Kategori</span>
					</a>
					{{-- Admin and Pemilik links --}}
					@if (Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik')
						<a href="{{ route('user.index') }}"
							class="{{ request()->routeIs('user.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} flex items-center px-6 py-3"
							style="{{ request()->routeIs('user.*') ? 'background: linear-gradient(135deg, #ff1493 0%, #d90b84 100%);' : '' }}">
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
						class="{{ request()->routeIs('kasir.*', 'order.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} flex items-center px-6 py-3"
						style="{{ request()->routeIs('kasir.*', 'order.*') ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);' : '' }}">
						<!-- Heroicon: shopping-cart -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
						</svg>
						<span class="mx-4 font-medium">Pesanan</span>
					</a>

					<!-- Pelanggan Terbaik Link - Accessible to all authenticated users -->
					<a href="{{ route('best-customer.index') }}"
						class="{{ request()->routeIs('best-customer.*') ? 'text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} flex items-center px-6 py-3"
						style="{{ request()->routeIs('best-customer.*') ? 'background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);' : '' }}">
						<!-- Heroicon: star -->
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
						</svg>
						<span class="mx-4 font-medium">Pelanggan Terbaik</span>
					</a>

					<!-- Logout Form -->
					<form action="/logout" method="POST">
						@csrf
						<button type="submit"
							class="flex w-full items-center px-6 py-3 text-slate-400 hover:bg-slate-800 hover:text-white">
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
				<header class="flex items-center justify-between border-b border-slate-700 bg-slate-900 p-4 shadow-md">
					<!-- Mobile menu button -->
					<button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white focus:outline-none md:hidden">
						<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
						</svg>
					</button>

					<div class="flex-1 text-right">
						<span class="font-medium text-slate-300">Selamat Datang, <span
								class="text-white">{{ Auth::user()->username ?? 'Pengguna' }}</span></span>
					</div>
				</header>

				<!-- Page Content -->
				<main class="flex-1 overflow-y-auto overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
					<div class="container mx-auto px-6 py-8">
						@yield('content')
					</div>
				</main>
			</div>
		</div>

		@stack('scripts')

	</body>

</html>
