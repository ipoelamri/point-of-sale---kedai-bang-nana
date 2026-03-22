<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Menu - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			@keyframes pulse-slow {

				0%,
				100% {
					opacity: 1;
				}

				50% {
					opacity: 0.8;
				}
			}

			@keyframes slideInFromBottom {
				from {
					opacity: 0;
					transform: translateY(30px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.animate-pulse-slow {
				animation: pulse-slow 3s ease-in-out infinite;
			}

			.info-card {
				animation: slideInFromBottom 0.6s ease-out forwards;
			}

			.info-card:nth-child(2) {
				animation-delay: 0.1s;
			}

			.info-card:nth-child(3) {
				animation-delay: 0.2s;
			}

			.stat-card {
				animation: slideInFromBottom 0.5s ease-out forwards;
				opacity: 0;
			}

			.stat-card:nth-child(1) {
				animation-delay: 0.1s;
			}

			.stat-card:nth-child(2) {
				animation-delay: 0.2s;
			}

			.stat-card:nth-child(3) {
				animation-delay: 0.3s;
			}

			.stat-card:nth-child(4) {
				animation-delay: 0.4s;
			}

			from {
				opacity: 0;
				transform: translateY(-20px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
			}

			@keyframes fadeIn {
				from {
					opacity: 0;
				}

				to {
					opacity: 1;
				}
			}

			@keyframes scaleIn {
				from {
					opacity: 0;
					transform: scale(0.9);
				}

				to {
					opacity: 1;
					transform: scale(1);
				}
			}

			@keyframes slideInLeft {
				from {
					opacity: 0;
					transform: translateX(-30px);
				}

				to {
					opacity: 1;
					transform: translateX(0);
				}
			}

			@keyframes slideInRight {
				from {
					opacity: 0;
					transform: translateX(30px);
				}

				to {
					opacity: 1;
					transform: translateX(0);
				}
			}

			@keyframes pulse {

				0%,
				100% {
					opacity: 1;
				}

				50% {
					opacity: 0.5;
				}
			}

			@keyframes bounce {

				0%,
				100% {
					transform: translateY(0);
				}

				50% {
					transform: translateY(-10px);
				}
			}

									.carousel-track {

										transition: transform 0.5s ease-in-out;

									}

						

									.animate-slide-down {

										animation: slideDown 0.5s ease-out;

									}

						

									.animate-fade-in {

										animation: fadeIn 0.6s ease-out;

									}

						

									.animate-scale-in {

										animation: scaleIn 0.4s ease-out;

									}

						

									.animate-bounce {

										animation: bounce 2s infinite;

									}

			

						.menu-card {

							transition: all 0.3s ease;

						}

			.menu-card:hover {
				transform: translateY(-8px);
				box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
			}

			.filter-btn {
				transition: all 0.3s ease;
			}

			.filter-btn.active {
				animation: scaleIn 0.3s ease;
			}

			.stat-card {
				transition: all 0.3s ease;
			}

			.stat-card:hover {
				transform: scale(1.05);
			}
		</style>
	</head>

	<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 shadow-lg" style="background: linear-gradient(135deg, #000000 0%, #000000 100%);">
				<div class="mx-auto max-w-7xl px-4 py-4">
					<div class="flex items-center justify-between gap-4">
						<div class="animate-slide-down flex items-center gap-3">
							<img src="{{ asset('images/logo.png') }}" alt="Logo Kedai Bang Nana" class="h-12 w-12 object-contain">
							<div>
								<h1 class="text-3xl font-bold text-white">
									Kedai Bang Nana
								</h1>
								<p class="text-sm text-white opacity-90">Café & Resto Terbaik 🍽️</p>
							</div>
						</div>
						<div class="flex items-center gap-3 sm:gap-4">
							<div class="text-center sm:text-right">
								<p class="text-xs font-semibold text-white sm:text-sm">
									Keranjang Anda
								</p>
								<p class="text-lg font-bold text-white sm:text-2xl">{{ count($cart) }}</p>
							</div>
							<a href="{{ route('cart.view') }}"
								class="rounded-full px-4 py-2.5 font-semibold text-white shadow-lg transition hover:shadow-xl active:scale-95 sm:px-6"
								style="background: linear-gradient(135deg, #ff1493 0%, #d90b84 100%); ">
								🛒 Keranjang
							</a>
						</div>
					</div>
				</div>
			</header>
						<!-- Carousel Slider -->
						<div class="mx-auto w-full max-w-full overflow-hidden"
							style="background: linear-gradient(to bottom, #dc0080, #d90b84);">
							<div class="relative overflow-hidden rounded-2xl shadow-2xl">
								<div class="carousel-track flex">
									<!-- Slide 1 -->
									<div class="carousel-item relative w-full flex-shrink-0">
										<img src="{{ asset('images/image1.png') }}" alt="Menu Makanan" class="h-96 w-full object-cover">
										<div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
										<div class="absolute bottom-0 left-0 right-0 p-8 text-white">
											<h2 class="text-4xl font-extrabold drop-shadow-lg">Menu Pilihan Terbaik</h2>
											<p class="mt-2 text-lg text-slate-200 drop-shadow-md">Cita rasa istimewa yang tak terlupakan.</p>
										</div>
									</div>
									<!-- Slide 2 -->
									<div class="carousel-item relative w-full flex-shrink-0">
										<img src="{{ asset('images/image2.png') }}" alt="Menu Minuman" class="h-96 w-full object-cover">
										<div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
										<div class="absolute bottom-0 left-0 right-0 p-8 text-white">
											<h2 class="text-4xl font-extrabold drop-shadow-lg">Minuman Segar & Nikmat</h2>
											<p class="mt-2 text-lg text-slate-200 drop-shadow-md">Menemani setiap momen santai Anda.</p>
										</div>
									</div>
									<!-- Slide 3 -->
									<div class="carousel-item relative w-full flex-shrink-0">
										<img src="{{ asset('images/image3.png') }}" alt="Menu Spesial" class="h-96 w-full object-cover">
										<div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
										<div class="absolute bottom-0 left-0 right-0 p-8 text-white">
											<h2 class="text-4xl font-extrabold drop-shadow-lg">Promo Spesial Hari Ini!</h2>
											<p class="mt-2 text-lg text-slate-200 drop-shadow-md">Dapatkan penawaran terbaik hanya untuk Anda.</p>
										</div>
									</div>
								</div>
								<!-- Dots -->
								<div class="carousel-dots absolute bottom-4 left-1/2 flex -translate-x-1/2 space-x-2">
									<button class="dot h-3 w-3 rounded-full bg-white/50 transition-colors duration-300"></button>
									<button class="dot h-3 w-3 rounded-full bg-white/50 transition-colors duration-300"></button>
									<button class="dot h-3 w-3 rounded-full bg-white/50 transition-colors duration-300"></button>
								</div>
							</div>
						</div>
						<!-- Main Content -->
						<main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
							<!-- Hero Banner -->
							<div
								class="animate-fade-in mb-12 overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 via-pink-600 to-pink-500 p-8 text-white shadow-xl sm:p-12">
								<p class="text-base text-white sm:text-lg">Nikmati berbagai pilihan makanan dan minuman lezat dengan kualitas
									terbaik dari Kedai Bang Nana 😋</p>
							</div>
			
							<!-- Alert Messages -->
							@if ($errors->any())
								<div class="animate-scale-in mb-6 rounded-xl border border-rose-900 bg-rose-950 p-4">
									<h3 class="mb-2 font-semibold text-rose-300">⚠️ Error:</h3>
									<ul class="list-inside list-disc space-y-1 text-sm text-rose-700">
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
			
							@if (session('success'))
								<div
									class="animate-scale-in mb-6 flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
									<div class="flex items-center gap-2">
										<span class="text-xl">✅</span>
										<span>{{ session('success') }}</span>
									</div>
									<button onclick="this.parentElement.style.display='none'"
										class="font-bold text-emerald-600 hover:text-emerald-800">
										✕
									</button>
								</div>
							@endif
							<!-- Stats Section -->
							<div class="mb-12 grid grid-cols-2 gap-4 sm:grid-cols-4">
								<div
									class="stat-card rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-500 p-6 text-center text-white shadow-lg">
									<div class="text-4xl font-bold">{{ $kategoris->count() }}</div>
									<p class="mt-2 text-sm opacity-90">Kategori Menu</p>
								</div>
								<div class="stat-card rounded-xl p-6 text-center text-white shadow-lg"
									style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
									<div class="text-4xl font-bold">100+</div>
									<p class="mt-2 text-sm opacity-90">Menu Pilihan</p>
								</div>
								<div class="stat-card rounded-xl p-6 text-center text-white shadow-lg"
									style="background: linear-gradient(135deg, #d90b84 0%, #c00860 100%);">
									<div class="text-4xl font-bold">⭐ 4.8</div>
									<p class="mt-2 text-sm opacity-90">Rating</p>
								</div>
								<div class="stat-card rounded-xl p-6 text-center text-white shadow-lg"
									style="background: linear-gradient(135deg, #dc0080 0%, #e91e63 100%);">
									<div class="text-4xl font-bold">24/7</div>
									<p class="mt-2 text-sm opacity-90">Buka Jam</p>
								</div>
							</div>
							<!-- Featured Menu Section -->
							<div class="mb-12 sm:mb-16">
								<h2
									class="mb-8 flex items-center justify-center gap-3 text-center text-2xl font-bold text-white sm:text-3xl">
									<span class="text-3xl">⭐</span> Menu Favorit Pelanggan <span class="text-3xl">⭐</span>
								</h2>
			
								<div
									class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 p-1 shadow-2xl">
									<div class="rounded-xl border border-slate-700 bg-slate-900 p-8">
										<div class="featured-carousel">
											<div class="animate-pulse-slow flex gap-6">
												<div
													class="featured-item group relative h-72 w-full flex-shrink-0 overflow-hidden rounded-xl shadow-lg sm:w-1/3">
													<img src="{{ asset('images/image1.png') }}" alt="Nasi Goreng Istimewa"
														class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
													<div
														class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent">
													</div>
													<div class="absolute right-4 top-4">
														<span
															class="rounded-full bg-red-500 px-4 py-1 text-sm font-bold text-white">BEST</span>
													</div>
													<div class="absolute bottom-0 left-0 right-0 p-6 text-white">
														<h3 class="mb-2 text-2xl font-bold">Nasi Goreng Istimewa</h3>
														<div class="flex items-center justify-between">
															<span class="text-2xl font-bold text-orange-400">Rp. 35.000</span>
															<span class="text-sm text-orange-300">⭐ 4.9/5</span>
														</div>
													</div>
												</div>
			
												<div
													class="featured-item group relative h-72 w-full flex-shrink-0 overflow-hidden rounded-xl shadow-lg sm:w-1/3">
													<img src="{{ asset('images/image2.png') }}" alt="Soto Ayam Kuning"
														class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
													<div
														class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent">
													</div>
													<div class="absolute right-4 top-4">
														<span
															class="rounded-full bg-red-500 px-4 py-1 text-sm font-bold text-white">TOP</span>
													</div>
													<div class="absolute bottom-0 left-0 right-0 p-6 text-white">
														<h3 class="mb-2 text-2xl font-bold">Soto Ayam Kuning</h3>
														<div class="flex items-center justify-between">
															<span class="text-2xl font-bold text-blue-400">Rp. 30.000</span>
															<span class="text-sm text-blue-300">⭐ 4.8/5</span>
														</div>
													</div>
												</div>
			
												<div
													class="featured-item group relative h-72 w-full flex-shrink-0 overflow-hidden rounded-xl shadow-lg sm:w-1/3">
													<img src="{{ asset('images/image3.png') }}" alt="Salad Segar Organik"
														class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
													<div
														class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent">
													</div>
													<div class="absolute right-4 top-4">
														<span class="rounded-full px-4 py-1 text-sm font-bold text-white"
															style="background-color: #dc0080;">HOT</span>
													</div>
													<div class="absolute bottom-0 left-0 right-0 p-6 text-white">
														<h3 class="mb-2 text-2xl font-bold">Salad Segar Organik</h3>
														<div class="flex items-center justify-between">
															<span class="text-2xl font-bold" style="color: #f97316;">Rp. 28.000</span>
															<span class="text-sm" style="color: #dc0080;">⭐ 4.7/5</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
			
							<!-- Info Section -->
							<div class="mb-12 grid grid-cols-1 gap-6 sm:grid-cols-3">
								<div
									class="info-card group rounded-xl border-l-4 border-emerald-500 bg-slate-800 p-6 shadow-lg transition-all duration-300 hover:border-emerald-400 hover:shadow-xl">
									<div class="mb-3 text-4xl transition-transform group-hover:scale-110">👨‍🍳</div>
									<h3 class="mb-2 text-lg font-bold text-white">Chef Berpengalaman</h3>
									<p class="text-sm text-slate-400">Menu dibuat oleh chef profesional dengan pengalaman lebih dari
										10 tahun.</p>
								</div>
			
								<div
									class="info-card group rounded-xl border-l-4 border-blue-500 bg-slate-800 p-6 shadow-lg transition-all duration-300 hover:border-blue-400 hover:shadow-xl">
									<div class="mb-3 text-4xl transition-transform group-hover:scale-110">🥬</div>
									<h3 class="mb-2 text-lg font-bold text-white">Bahan Segar</h3>
									<p class="text-sm text-slate-400">Semua bahan dipilih langsung dari pasar dengan standar
										kualitas terbaik.</p>
								</div>
			
								<div
									class="info-card group rounded-xl border-l-4 border-orange-500 bg-slate-800 p-6 shadow-lg transition-all duration-300 hover:border-orange-400 hover:shadow-xl">
									<div class="mb-3 text-4xl transition-transform group-hover:scale-110">⚡</div>
									<h3 class="mb-2 text-lg font-bold text-white">Cepat & Higienis</h3>
									<p class="text-sm text-slate-400">Makanan disiapkan dengan cepat dengan standar kebersihan
										tertinggi.</p>
								</div>
							</div>
			
							<!-- Kategori Filter Section -->
							<div class="mb-8 sm:mb-10">
								<p class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">Kategori</p>
								<div class="flex flex-wrap gap-2 sm:gap-3">
									<a href="{{ route('menu.public') }}"
										class="filter-btn {{ !$kategori ? 'active' : '' }} {{ !$kategori ? 'text-white shadow-lg' : 'bg-slate-800 text-slate-300 border-2 border-slate-600 hover:border-pink-400' }} rounded-full px-5 py-2.5 font-semibold transition sm:px-7"
										style="{{ !$kategori ? 'background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);' : '' }}">
										🎯 Semua Menu
									</a>
									@foreach ($kategoris as $kat)
										<a href="{{ route('menu.public', ['kategori' => $kat->nama_kategori]) }}"
											class="filter-btn {{ $kategori === $kat->nama_kategori ? 'active' : '' }} {{ $kategori === $kat->nama_kategori ? 'text-white shadow-lg' : 'bg-slate-800 text-slate-300 border-2 border-slate-600 hover:border-pink-400' }} rounded-full px-5 py-2.5 font-semibold transition sm:px-7"
											style="{{ $kategori === $kat->nama_kategori ? 'background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);' : '' }}">
											{{ $kat->nama_kategori === 'Makanan' ? '🍜' : '🥤' }} {{ $kat->nama_kategori }}
										</a>
									@endforeach
								</div>
							</div>
			
							<!-- Menu Grid -->
							@if ($menus->count() > 0)
								<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
									@foreach ($menus as $menu)
										<div
											class="menu-card animate-scale-in group overflow-hidden rounded-2xl border border-slate-700 bg-slate-900 shadow-lg">
											<!-- Image Container -->
											<div
												class="relative h-52 overflow-hidden bg-gradient-to-br from-slate-800 to-slate-700">
												@php
													$storagePath = public_path('storage/' . $menu->foto);
													$uploadsPath = public_path('uploads/' . $menu->foto);
													if (file_exists($storagePath)) {
													    $src = asset('storage/' . $menu->foto);
													} elseif (file_exists($uploadsPath)) {
													    $src = asset('uploads/' . $menu->foto);
													} else {
													    // Placeholder gambar berdasarkan kategori
													    $src =
													        $menu->kategori->nama_kategori === 'Makanan'
													            ? 'https://via.placeholder.com/300x200?text=Gambar1'
													            : 'https://via.placeholder.com/300x200?text=Gambar2';
													}
												@endphp
												<img src="{{ $src }}" alt="{{ $menu->nama_menu }}"
													class="h-full w-full object-cover transition duration-500 group-hover:scale-110 group-hover:brightness-110">
			
												<!-- Badge -->
												<div class="absolute right-4 top-4">
													<span class="rounded-full px-3 py-1 text-xs font-bold text-white shadow-lg"
														style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
														{{ $menu->kategori->nama_kategori === 'Makanan' ? '🍜' : '🥤' }}
													</span>
												</div>
			
												<!-- Stock Badge -->
												<div class="absolute bottom-4 left-4">
													<span
														class="{{ $menu->stok > 0 ? 'bg-emerald-500' : 'bg-red-500' }} rounded-full px-3 py-1 text-xs font-bold text-white shadow-lg">
														{{ $menu->stok }} pcs
													</span>
												</div>
											</div>
			
											<!-- Content -->
											<div class="flex flex-col p-5">
												<h3 class="mb-2 line-clamp-2 text-lg font-bold text-white">{{ $menu->nama_menu }}
												</h3>
												<p class="mb-3 text-xs text-slate-400">Kategori: <span class="font-semibold"
														style="color: #dc0080;">{{ $menu->kategori->nama_kategori }}</span></p>
												@if ($menu->deskripsi)
													<p class="mb-4 line-clamp-2 text-sm text-slate-400">{{ $menu->deskripsi }}</p>
												@endif
			
												<!-- Price -->
												<div class="mb-4 flex items-baseline gap-2">
													<span class="text-3xl font-bold text-orange-400">Rp
														{{ number_format($menu->harga, 0, ',', '.') }}</span>
													<span class="text-xs text-slate-500">/ porsi</span>
												</div>
			
												<!-- Add to Cart Form -->
												<form action="{{ route('cart.add', $menu->id_menu) }}" method="POST"
													class="mt-auto space-y-3">
													@csrf
													<div class="flex items-center gap-2">
														<input type="number" name="quantity" value="1" min="1"
															max="{{ $menu->stok }}"
															class="w-20 rounded-lg border-2 border-slate-600 bg-slate-800 px-3 py-2 text-sm font-semibold text-white focus:outline-none"
															style="focus-border-color: #dc0080;">
														<button type="submit" {{ $menu->stok <= 0 ? 'disabled' : '' }}
															class="{{ $menu->stok <= 0 ? 'bg-slate-600 cursor-not-allowed' : 'active:scale-95' }} flex-1 rounded-lg py-2.5 font-bold text-white shadow-lg transition"
															style="{{ $menu->stok <= 0 ? '' : 'background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);' }}">
															{{ $menu->stok > 0 ? '🛒 Tambah Keranjang' : 'Habis' }}
														</button>
													</div>
												</form>
											</div>
										</div>
									@endforeach
								</div>
			
								<!-- Pagination -->
								<div class="mt-12 flex justify-center">
									{{ $menus->links() }}
								</div>
							@else
								<div
									class="rounded-2xl border-2 border-dashed border-slate-700 bg-slate-800 py-16 text-center shadow-sm">
									<p class="mb-4 text-5xl">🔍</p>
									<p class="mb-2 text-2xl font-bold text-white">Belum ada menu tersedia</p>
									<p class="text-slate-400">Silakan pilih kategori lain atau periksa kembali nanti</p>
								</div>
							@endif
					</div>
					</main>
			
					<!-- Footer -->
					<footer class="mt-16 bg-gradient-to-r from-slate-800 to-slate-900 py-8 text-center text-slate-300">
						<p class="text-sm">✨ &copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi. ✨</p>
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
					const itemCount = items.length;
					let currentIndex = 0;
					let carouselInterval;

					function updateCarousel(isManual = false) {
						track.style.transform = `translateX(-${currentIndex * 100}%)`;
						dots.forEach((dot, index) => {
							dot.classList.toggle('bg-white', index === currentIndex);
							dot.classList.toggle('bg-white/50', index !== currentIndex);
						});

						if (isManual) {
							// Reset interval on manual navigation
							clearInterval(carouselInterval);
							startInterval();
						}
					}

					function startInterval() {
						carouselInterval = setInterval(() => {
							currentIndex = (currentIndex + 1) % itemCount;
							updateCarousel();
						}, 3000);
					}

					dots.forEach((dot, index) => {
						dot.addEventListener('click', () => {
							currentIndex = index;
							updateCarousel(true);
						});
					});

					// Set initial state and start the automatic slide
					updateCarousel();
					startInterval();
				}
			});
		</script>
	</body>
			
			</html>
