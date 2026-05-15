<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>@yield('title', 'Admin Dashboard') - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		@vite('resources/css/app.css')
		<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
	</head>

	<body class="gradient-surface font-sans text-slate-200 antialiased">

		<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
			<!-- Overlay for mobile -->
			<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
				x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
				x-transition:leave="transition-opacity ease-in duration-200"
				x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
				@click="sidebarOpen = false"
				class="fixed inset-0 z-20 bg-black/60 backdrop-blur-sm md:hidden"></div>

			<!-- Sidebar -->
			<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
				class="fixed inset-y-0 left-0 z-30 flex w-[260px] flex-col transform glass-strong transition-transform duration-300 ease-in-out md:relative md:translate-x-0">

				<!-- Logo -->
				<div class="flex items-center gap-3 px-5 py-5">
					<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-primary shadow-lg">
						<span class="text-lg font-bold text-white">N</span>
					</div>
					<div>
						<h2 class="text-lg font-bold text-white">
							Kedai Bang <span class="text-gradient-primary">Nana</span>
						</h2>
						<p class="text-[10px] font-medium uppercase tracking-widest text-slate-500">POS System</p>
					</div>
				</div>

				<!-- User Info -->
				<div class="mx-4 mb-4 rounded-xl bg-slate-800/50 px-4 py-3">
					<div class="flex items-center gap-3">
						<div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-pink-500 to-violet-500 text-sm font-bold text-white">
							{{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
						</div>
						<div class="min-w-0 flex-1">
							<p class="truncate text-sm font-semibold text-white">{{ Auth::user()->username ?? 'Pengguna' }}</p>
							<p class="text-xs capitalize text-slate-400">{{ Auth::user()->role ?? 'user' }}</p>
						</div>
					</div>
				</div>

				<!-- Nav Links -->
				<nav class="flex-1 space-y-1 overflow-y-auto px-3 pb-4">
					<p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Menu Utama</p>

					<a href="{{ route('dashboard') }}"
						class="{{ request()->routeIs('dashboard') ? 'bg-pink-500/15 text-pink-400 border-pink-500/30' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
						<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
						</svg>
						<span>Dashboard</span>
					</a>

					{{-- Admin and Pemilik links --}}
					@if (Auth::user()->role == 'admin' || Auth::user()->role == 'pemilik')
						<p class="mb-2 mt-5 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Manajemen</p>

						<a href="{{ route('menu.index') }}"
							class="{{ request()->routeIs('menu.*') ? 'bg-amber-500/15 text-amber-400 border-amber-500/30' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
							<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
							</svg>
							<span>Menu</span>
						</a>

						<a href="{{ route('kategori.index') }}"
							class="{{ request()->routeIs('kategori.*') ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
							<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
							</svg>
							<span>Kategori</span>
						</a>

						<a href="{{ route('user.index') }}"
							class="{{ request()->routeIs('user.*') ? 'bg-violet-500/15 text-violet-400 border-violet-500/30' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
							<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
								stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
							</svg>
							<span>Users</span>
						</a>
					@endif

					<p class="mb-2 mt-5 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Operasional</p>

					<a href="{{ route('kasir.pesanan') }}"
						class="{{ request()->routeIs('kasir.*', 'order.*') ? 'bg-emerald-500/15 text-emerald-400 border-emerald-500/30' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
						<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
						</svg>
						<span>Pesanan</span>
					</a>

					<!-- Pelanggan Terbaik Link - Accessible to all authenticated users -->
					<a href="{{ route('best-customer.index') }}"
						class="{{ request()->routeIs('best-customer.*') ? 'bg-violet-500/15 text-violet-400 border-violet-500/30' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5' }} flex items-center gap-3 rounded-xl border px-3 py-2.5 text-sm font-medium transition-all duration-200">
						<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
						</svg>
						<span>Pelanggan Terbaik</span>
					</a>
				</nav>

				<!-- Logout -->
				<div class="border-t border-white/5 p-3">
					<form action="/logout" method="POST">
						@csrf
						<button type="submit"
							class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400 transition-all duration-200 hover:bg-red-500/10 hover:text-red-400">
							<svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
							</svg>
							<span>Keluar</span>
						</button>
					</form>
				</div>
			</aside>

			<!-- Main content -->
			<div class="flex flex-1 flex-col overflow-hidden">
				<!-- Header -->
				<header class="glass flex items-center justify-between px-4 py-3 md:px-6">
					<!-- Mobile menu button -->
					<button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-slate-400 transition hover:bg-white/5 hover:text-white focus:outline-none md:hidden">
						<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
						</svg>
					</button>

					<!-- Page title area -->
					<div class="hidden md:block">
						<h2 class="text-sm font-semibold text-white">@yield('title', 'Dashboard')</h2>
					</div>

					<div class="flex items-center gap-3">
						<span class="hidden text-sm text-slate-400 sm:inline">Selamat datang,</span>
						<div class="flex items-center gap-2 rounded-lg bg-white/5 px-3 py-1.5">
							<div class="h-6 w-6 rounded-full bg-gradient-to-br from-pink-500 to-violet-500 text-center text-xs font-bold leading-6 text-white">
								{{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
							</div>
							<span class="text-sm font-medium text-white">{{ Auth::user()->username ?? 'Pengguna' }}</span>
						</div>
					</div>
				</header>

				<!-- Page Content -->
				<main class="flex-1 overflow-y-auto overflow-x-hidden">
					<div class="mx-auto max-w-7xl px-4 py-6 md:px-6 md:py-8">
						@yield('content')
					</div>
				</main>
			</div>
		</div>

		@stack('scripts')

	</body>

</html>
