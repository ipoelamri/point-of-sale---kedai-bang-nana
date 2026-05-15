<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Menu - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			.carousel-track { transition: transform 0.5s ease-in-out; }
			.menu-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
			.menu-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
			.stat-card { transition: all 0.3s ease; }
			.stat-card:hover { transform: scale(1.03); }
			.filter-btn { transition: all 0.25s ease; }
			@keyframes fadeInUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
			.animate-stagger > * { opacity: 0; animation: fadeInUp 0.5s ease-out forwards; }
			.animate-stagger > *:nth-child(1) { animation-delay: 0.05s; }
			.animate-stagger > *:nth-child(2) { animation-delay: 0.1s; }
			.animate-stagger > *:nth-child(3) { animation-delay: 0.15s; }
			.animate-stagger > *:nth-child(4) { animation-delay: 0.2s; }
		</style>
	</head>

	<body class="gradient-surface font-sans antialiased">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 glass-strong">
				<div class="mx-auto max-w-7xl px-4 py-3">
					<div class="flex items-center justify-between gap-4">
						<div class="flex items-center gap-3">
							<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-primary shadow-lg shadow-pink-500/25">
								<span class="text-lg font-bold text-white">N</span>
							</div>
							<div>
								<h1 class="text-xl font-bold text-white sm:text-2xl">Kedai Bang <span class="text-gradient-primary">Nana</span></h1>
								<p class="text-xs text-slate-400">Café & Resto Terbaik 🍽️</p>
							</div>
						</div>
						<div class="flex items-center gap-3">
							<div class="hidden text-right sm:block">
								<p class="text-xs text-slate-400">Keranjang Anda</p>
								<p class="text-lg font-bold text-white">{{ count($cart) }}</p>
							</div>
							<a href="{{ route('cart.view') }}" class="btn btn-primary text-sm">
								🛒 <span class="hidden sm:inline">Keranjang</span> <span class="sm:hidden">({{ count($cart) }})</span>
							</a>
						</div>
					</div>
				</div>
			</header>

			<!-- Carousel -->
			<div class="w-full overflow-hidden">
				<div class="relative overflow-hidden">
					<div class="carousel-track flex">
						<div class="carousel-item relative w-full flex-shrink-0">
							<img src="{{ asset('images/image1.png') }}" alt="Menu Makanan" class="h-72 w-full object-cover sm:h-96">
							<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
							<div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-white">
								<h2 class="text-3xl font-extrabold drop-shadow-lg sm:text-4xl">Menu Pilihan Terbaik</h2>
								<p class="mt-2 text-base text-slate-200 drop-shadow-md">Cita rasa istimewa yang tak terlupakan.</p>
							</div>
						</div>
						<div class="carousel-item relative w-full flex-shrink-0">
							<img src="{{ asset('images/image2.png') }}" alt="Menu Minuman" class="h-72 w-full object-cover sm:h-96">
							<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
							<div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-white">
								<h2 class="text-3xl font-extrabold drop-shadow-lg sm:text-4xl">Minuman Segar & Nikmat</h2>
								<p class="mt-2 text-base text-slate-200 drop-shadow-md">Menemani setiap momen santai Anda.</p>
							</div>
						</div>
						<div class="carousel-item relative w-full flex-shrink-0">
							<img src="{{ asset('images/image3.png') }}" alt="Menu Spesial" class="h-72 w-full object-cover sm:h-96">
							<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
							<div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 text-white">
								<h2 class="text-3xl font-extrabold drop-shadow-lg sm:text-4xl">Promo Spesial Hari Ini!</h2>
								<p class="mt-2 text-base text-slate-200 drop-shadow-md">Dapatkan penawaran terbaik hanya untuk Anda.</p>
							</div>
						</div>
					</div>
					<div class="carousel-dots absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2">
						<button class="dot h-2.5 w-2.5 rounded-full bg-white/40 transition-all duration-300"></button>
						<button class="dot h-2.5 w-2.5 rounded-full bg-white/40 transition-all duration-300"></button>
						<button class="dot h-2.5 w-2.5 rounded-full bg-white/40 transition-all duration-300"></button>
					</div>
				</div>
			</div>

			<main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 sm:py-12">
				<!-- Hero -->
				<div class="mb-10 overflow-hidden rounded-2xl gradient-primary p-6 text-white shadow-lg shadow-pink-500/15 sm:p-10">
					<p class="text-base sm:text-lg">Nikmati berbagai pilihan makanan dan minuman lezat dengan kualitas terbaik dari Kedai Bang Nana 😋</p>
				</div>

				<!-- Alert Messages -->
				@if ($errors->any())
					<div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">
						<h3 class="mb-2 font-semibold text-red-300">⚠️ Error:</h3>
						<ul class="list-inside list-disc space-y-1 text-sm text-red-400">
							@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
						</ul>
					</div>
				@endif
				@if (session('success'))
					<div class="mb-6 flex items-center justify-between rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4">
						<div class="flex items-center gap-2 text-emerald-300"><span>✅</span><span>{{ session('success') }}</span></div>
						<button onclick="this.parentElement.style.display='none'" class="font-bold text-emerald-400 hover:text-emerald-200">✕</button>
					</div>
				@endif

				<!-- Stats -->
				<div class="animate-stagger mb-10 grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
					<div class="stat-card glass-card rounded-2xl p-5 text-center">
						<div class="text-3xl font-bold text-emerald-400">{{ $kategoris->count() }}</div>
						<p class="mt-1 text-xs text-slate-400">Kategori Menu</p>
					</div>
					<div class="stat-card glass-card rounded-2xl p-5 text-center">
						<div class="text-3xl font-bold text-pink-400">100+</div>
						<p class="mt-1 text-xs text-slate-400">Menu Pilihan</p>
					</div>
					<div class="stat-card glass-card rounded-2xl p-5 text-center">
						<div class="text-3xl font-bold text-amber-400">⭐ 4.8</div>
						<p class="mt-1 text-xs text-slate-400">Rating</p>
					</div>
					<div class="stat-card glass-card rounded-2xl p-5 text-center">
						<div class="text-3xl font-bold text-violet-400">24/7</div>
						<p class="mt-1 text-xs text-slate-400">Buka Jam</p>
					</div>
				</div>

				<!-- Featured Menu -->
				<div class="mb-12">
					<h2 class="mb-6 text-center text-xl font-bold text-white sm:text-2xl">⭐ Menu Favorit Pelanggan ⭐</h2>
					<div class="glass-card rounded-2xl p-1">
						<div class="rounded-xl bg-slate-900/80 p-4 sm:p-6">
							<div class="flex gap-4 overflow-x-auto pb-2 sm:gap-6">
								<div class="group relative h-64 w-full flex-shrink-0 overflow-hidden rounded-xl shadow-lg sm:w-1/3">
									<img src="{{ asset('images/image1.png') }}" alt="Nasi Goreng Istimewa" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
									<div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>
									<div class="absolute right-3 top-3"><span class="badge badge-danger text-xs">BEST</span></div>
									<div class="absolute bottom-0 left-0 right-0 p-4 text-white">
										<h3 class="text-lg font-bold">Nasi Goreng Istimewa</h3>
										<div class="mt-1 flex items-center justify-between">
											<span class="text-lg font-bold text-amber-400">Rp. 35.000</span>
											<span class="text-xs text-amber-300">⭐ 4.9/5</span>
										</div>
									</div>
								</div>
								<div class="group relative h-64 w-full flex-shrink-0 overflow-hidden rounded-xl shadow-lg sm:w-1/3">
									<img src="{{ asset('images/image2.png') }}" alt="Soto Ayam Kuning" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
									<div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>
									<div class="absolute right-3 top-3"><span class="badge badge-info text-xs">TOP</span></div>
									<div class="absolute bottom-0 left-0 right-0 p-4 text-white">
										<h3 class="text-lg font-bold">Soto Ayam Kuning</h3>
										<div class="mt-1 flex items-center justify-between">
											<span class="text-lg font-bold text-blue-400">Rp. 30.000</span>
											<span class="text-xs text-blue-300">⭐ 4.8/5</span>
										</div>
									</div>
								</div>
								<div class="group relative h-64 w-full flex-shrink-0 overflow-hidden rounded-xl shadow-lg sm:w-1/3">
									<img src="{{ asset('images/image3.png') }}" alt="Salad Segar Organik" class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
									<div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>
									<div class="absolute right-3 top-3"><span class="badge text-xs" style="background:rgba(236,72,153,0.2);color:#f472b6;border:1px solid rgba(236,72,153,0.3);">HOT</span></div>
									<div class="absolute bottom-0 left-0 right-0 p-4 text-white">
										<h3 class="text-lg font-bold">Salad Segar Organik</h3>
										<div class="mt-1 flex items-center justify-between">
											<span class="text-lg font-bold text-amber-400">Rp. 28.000</span>
											<span class="text-xs text-pink-300">⭐ 4.7/5</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Info Cards -->
				<div class="mb-12 grid grid-cols-1 gap-4 sm:grid-cols-3">
					<div class="glass-card card-hover group rounded-2xl p-5">
						<div class="mb-3 text-3xl transition-transform group-hover:scale-110">👨‍🍳</div>
						<h3 class="mb-1 text-base font-bold text-white">Chef Berpengalaman</h3>
						<p class="text-sm text-slate-400">Menu dibuat oleh chef profesional dengan pengalaman lebih dari 10 tahun.</p>
					</div>
					<div class="glass-card card-hover group rounded-2xl p-5">
						<div class="mb-3 text-3xl transition-transform group-hover:scale-110">🥬</div>
						<h3 class="mb-1 text-base font-bold text-white">Bahan Segar</h3>
						<p class="text-sm text-slate-400">Semua bahan dipilih langsung dari pasar dengan standar kualitas terbaik.</p>
					</div>
					<div class="glass-card card-hover group rounded-2xl p-5">
						<div class="mb-3 text-3xl transition-transform group-hover:scale-110">⚡</div>
						<h3 class="mb-1 text-base font-bold text-white">Cepat & Higienis</h3>
						<p class="text-sm text-slate-400">Makanan disiapkan dengan cepat dengan standar kebersihan tertinggi.</p>
					</div>
				</div>

				<!-- Kategori Filter -->
				<div class="mb-8">
					<p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">Kategori</p>
					<div class="flex flex-wrap gap-2">
						<a href="{{ route('menu.public') }}"
							class="filter-btn {{ !$kategori ? 'gradient-primary text-white shadow-lg shadow-pink-500/20' : 'glass text-slate-300 hover:text-white hover:bg-white/10' }} rounded-full px-5 py-2 text-sm font-semibold">
							🎯 Semua Menu
						</a>
						@foreach ($kategoris as $kat)
							<a href="{{ route('menu.public', ['kategori' => $kat->nama_kategori]) }}"
								class="filter-btn {{ $kategori === $kat->nama_kategori ? 'gradient-primary text-white shadow-lg shadow-pink-500/20' : 'glass text-slate-300 hover:text-white hover:bg-white/10' }} rounded-full px-5 py-2 text-sm font-semibold">
								{{ $kat->nama_kategori === 'Makanan' ? '🍜' : '🥤' }} {{ $kat->nama_kategori }}
							</a>
						@endforeach
					</div>
				</div>

				<!-- Menu Grid -->
				@if ($menus->count() > 0)
					<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
						@foreach ($menus as $menu)
							<div class="menu-card group glass-card overflow-hidden rounded-2xl">
								<div class="relative h-48 overflow-hidden">
									@php
										$storagePath = public_path('storage/' . $menu->foto);
										$uploadsPath = public_path('uploads/' . $menu->foto);
										if (file_exists($storagePath)) { $src = asset('storage/' . $menu->foto); }
										elseif (file_exists($uploadsPath)) { $src = asset('uploads/' . $menu->foto); }
										else { $src = $menu->kategori->nama_kategori === 'Makanan' ? 'https://via.placeholder.com/300x200?text=Gambar1' : 'https://via.placeholder.com/300x200?text=Gambar2'; }
									@endphp
									<img src="{{ $src }}" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
									<div class="absolute right-3 top-3">
										<span class="badge text-xs" style="background:rgba(236,72,153,0.2);color:#f472b6;border:1px solid rgba(236,72,153,0.3);">
											{{ $menu->kategori->nama_kategori === 'Makanan' ? '🍜' : '🥤' }}
										</span>
									</div>
									<div class="absolute bottom-3 left-3">
										<span class="badge text-xs {{ $menu->stok > 0 ? 'badge-success' : 'badge-danger' }}">{{ $menu->stok }} pcs</span>
									</div>
								</div>
								<div class="flex flex-col p-4">
									<h3 class="mb-1 line-clamp-2 text-base font-bold text-white">{{ $menu->nama_menu }}</h3>
									<p class="mb-2 text-xs text-slate-500">Kategori: <span class="font-medium text-pink-400">{{ $menu->kategori->nama_kategori }}</span></p>
									@if ($menu->deskripsi)
										<p class="mb-3 line-clamp-2 text-sm text-slate-400">{{ $menu->deskripsi }}</p>
									@endif
									<div class="mb-3 flex items-baseline gap-1">
										<span class="text-2xl font-bold text-amber-400">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
										<span class="text-xs text-slate-500">/ porsi</span>
									</div>
									<form action="{{ route('cart.add', $menu->id_menu) }}" method="POST" class="mt-auto">
										@csrf
										<div class="flex items-center gap-2">
											<input type="number" name="quantity" value="1" min="1" max="{{ $menu->stok }}"
												class="form-input w-16 px-2 py-2 text-center text-sm">
											<button type="submit" {{ $menu->stok <= 0 ? 'disabled' : '' }}
												class="{{ $menu->stok <= 0 ? 'bg-slate-700 text-slate-500 cursor-not-allowed' : 'btn-primary active:scale-95' }} btn flex-1 py-2 text-sm">
												{{ $menu->stok > 0 ? '🛒 Tambah' : 'Habis' }}
											</button>
										</div>
									</form>
								</div>
							</div>
						@endforeach
					</div>
					<div class="mt-12 flex justify-center">{{ $menus->links() }}</div>
				@else
					<div class="glass-card rounded-2xl py-16 text-center">
						<p class="mb-4 text-5xl">🔍</p>
						<p class="mb-2 text-xl font-bold text-white">Belum ada menu tersedia</p>
						<p class="text-slate-400">Silakan pilih kategori lain atau periksa kembali nanti</p>
					</div>
				@endif
			</main>

			<footer class="mt-16 glass py-8 text-center text-sm text-slate-400">
				<p>✨ &copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi. ✨</p>
				<p class="mt-2 text-xs text-slate-500">Terima kasih telah mengunjungi kami! 🙏</p>
			</footer>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const track = document.querySelector('.carousel-track');
				const dotsContainer = document.querySelector('.carousel-dots');
				if (track && dotsContainer) {
					const items = track.querySelectorAll('.carousel-item');
					const dots = dotsContainer.querySelectorAll('.dot');
					let currentIndex = 0;
					let carouselInterval;
					function updateCarousel(isManual = false) {
						track.style.transform = `translateX(-${currentIndex * 100}%)`;
						dots.forEach((dot, index) => {
							dot.classList.toggle('!bg-white', index === currentIndex);
							dot.classList.toggle('!w-6', index === currentIndex);
						});
						if (isManual) { clearInterval(carouselInterval); startInterval(); }
					}
					function startInterval() { carouselInterval = setInterval(() => { currentIndex = (currentIndex + 1) % items.length; updateCarousel(); }, 3000); }
					dots.forEach((dot, index) => { dot.addEventListener('click', () => { currentIndex = index; updateCarousel(true); }); });
					updateCarousel();
					startInterval();
				}
			});
		</script>
	</body>
</html>
