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

			@keyframes carousel-slide {
				0% {
					transform: translateX(0);
				}

				20% {
					transform: translateX(0);
				}

				25% {
					transform: translateX(-100%);
				}

				45% {
					transform: translateX(-100%);
				}

				50% {
					transform: translateX(-200%);
				}

				70% {
					transform: translateX(-200%);
				}

				75% {
					transform: translateX(-300%);
				}

				95% {
					transform: translateX(-300%);
				}

				100% {
					transform: translateX(0);
				}
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

			.carousel-container {
				overflow: hidden;
				display: flex;
			}

			.carousel-slide {
				animation: carousel-slide 20s infinite ease-in-out;
				flex: 0 0 25%;
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

	<body class="bg-gradient-to-br from-slate-50 via-amber-50 to-slate-50">
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
			<!-- Carousel Animasi Banner -->
			<div class="overflow-hidden py-8" style="background: linear-gradient(to bottom, #dc0080, #d90b84);">
				<div class="carousel-container">
					<div class="carousel-slide flex gap-4 px-4">
						<div
							class="flex w-72 flex-shrink-0 flex-col items-center justify-center rounded-xl bg-white p-6 text-center shadow-lg">
							<div class="mb-3 text-6xl">🍜</div>
							<h3 class="text-xl font-bold text-slate-800">Nasi Goreng Spesial</h3>
							<p class="mt-2 text-sm text-slate-600">Gurih, lezat, dan menggugah selera</p>
						</div>
						<div
							class="flex w-72 flex-shrink-0 flex-col items-center justify-center rounded-xl bg-white p-6 text-center shadow-lg">
							<div class="mb-3 text-6xl">🍲</div>
							<h3 class="text-xl font-bold text-slate-800">Soto Ayam</h3>
							<p class="mt-2 text-sm text-slate-600">Hangat, tradisional, dan berkuah nikmat</p>
						</div>
						<div
							class="flex w-72 flex-shrink-0 flex-col items-center justify-center rounded-xl bg-white p-6 text-center shadow-lg">
							<div class="mb-3 text-6xl">🥤</div>
							<h3 class="text-xl font-bold text-slate-800">Es Teh Manis</h3>
							<p class="mt-2 text-sm text-slate-600">Segar, dingin, dan menyegarkan tenggorokan</p>
						</div>
						<div
							class="flex w-72 flex-shrink-0 flex-col items-center justify-center rounded-xl bg-white p-6 text-center shadow-lg">
							<div class="mb-3 text-6xl">🍰</div>
							<h3 class="text-xl font-bold text-slate-800">Kue Tart</h3>
							<p class="mt-2 text-sm text-slate-600">Manis, lembut, dan sempurna untuk acara</p>
						</div>
					</div>
				</div>
			</div>
			<!-- Main Content -->
			<main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:py-12">
				<!-- Hero Banner -->
				<div
					class="animate-fade-in mb-12 overflow-hidden rounded-2xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-300 p-8 text-white shadow-xl sm:p-12">
					<div class="max-w-2xl">
						<h2 class="mb-3 text-4xl font-bold sm:text-5xl">Pilih Menu Favorit Anda</h2>
						<p class="text-base text-white sm:text-lg">Nikmati berbagai pilihan makanan dan minuman lezat dengan kualitas
							terbaik dari Kedai Bang Nana 😋</p>
					</div>
				</div>

				<!-- Alert Messages -->
				@if ($errors->any())
					<div class="animate-scale-in mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4">
						<h3 class="mb-2 font-semibold text-rose-800">⚠️ Error:</h3>
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
					<h2 class="mb-8 flex items-center justify-center gap-3 text-center text-2xl font-bold text-gray-800 sm:text-3xl">
						<span class="text-3xl">⭐</span> Menu Favorit Pelanggan <span class="text-3xl">⭐</span>
					</h2>

					<div
						class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 p-1 shadow-2xl">
						<div class="rounded-xl bg-white p-8">
							<div class="featured-carousel">
								<div class="animate-pulse-slow flex gap-6">
									<div
										class="featured-item w-full flex-shrink-0 rounded-xl border-2 border-yellow-200 bg-gradient-to-br from-yellow-50 to-orange-50 p-6 shadow-md transition-all duration-300 hover:shadow-xl sm:w-1/3">
										<div class="mb-3 flex items-start justify-between">
											<span class="text-5xl">🍜</span>
											<span class="text-lg font-bold text-red-500">BEST</span>
										</div>
										<h3 class="mb-2 text-xl font-bold text-gray-800">Nasi Goreng Istimewa</h3>
										<p class="mb-3 text-sm text-gray-600">Nasi putih yang digoreng dengan telur, udang, dan sayuran segar.</p>
										<div class="flex items-center justify-between">
											<span class="text-2xl font-bold text-orange-600">Rp. 35K</span>
											<span class="rounded-full bg-orange-100 px-3 py-1 text-sm text-orange-700">⭐ 4.9/5</span>
										</div>
									</div>

									<div
										class="featured-item w-full flex-shrink-0 rounded-xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-cyan-50 p-6 shadow-md transition-all duration-300 hover:shadow-xl sm:w-1/3">
										<div class="mb-3 flex items-start justify-between">
											<span class="text-5xl">🍲</span>
											<span class="text-lg font-bold text-red-500">TOP</span>
										</div>
										<h3 class="mb-2 text-xl font-bold text-gray-800">Soto Ayam Kuning</h3>
										<p class="mb-3 text-sm text-gray-600">Kuah kunyit gurih dengan daging ayam lembut dan rempah pilihan.</p>
										<div class="flex items-center justify-between">
											<span class="text-2xl font-bold text-blue-600">Rp. 30K</span>
											<span class="rounded-full bg-blue-100 px-3 py-1 text-sm text-blue-700">⭐ 4.8/5</span>
										</div>
									</div>

									<div
										class="featured-item w-full flex-shrink-0 rounded-xl border-2 p-6 shadow-md transition-all duration-300 hover:shadow-xl sm:w-1/3"
										style="border-color: #dc0080; background: linear-gradient(135deg, #fce7f3 0%, #fce7f3 100%);">
										<div class="mb-3 flex items-start justify-between">
											<span class="text-5xl">🥗</span>
											<span class="text-lg font-bold" style="color: #dc0080;">HOT</span>
										</div>
										<h3 class="mb-2 text-xl font-bold text-gray-800">Salad Segar Organik</h3>
										<p class="mb-3 text-sm text-gray-600">Sayuran hijau segar dengan dressing vinaigrette yang menyegarkan.</p>
										<div class="flex items-center justify-between">
											<span class="text-2xl font-bold" style="color: #dc0080;">Rp. 28K</span>
											<span class="rounded-full px-3 py-1 text-sm" style="background-color: #fce7f3; color: #dc0080;">⭐
												4.7/5</span>
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
						class="info-card group rounded-xl border-l-4 border-emerald-500 bg-white p-6 shadow-lg transition-all duration-300 hover:border-emerald-600 hover:shadow-xl">
						<div class="mb-3 text-4xl transition-transform group-hover:scale-110">👨‍🍳</div>
						<h3 class="mb-2 text-lg font-bold text-gray-800">Chef Berpengalaman</h3>
						<p class="text-sm text-gray-600">Menu dibuat oleh chef profesional dengan pengalaman lebih dari 10 tahun.</p>
					</div>

					<div
						class="info-card group rounded-xl border-l-4 border-blue-500 bg-white p-6 shadow-lg transition-all duration-300 hover:border-blue-600 hover:shadow-xl">
						<div class="mb-3 text-4xl transition-transform group-hover:scale-110">🥬</div>
						<h3 class="mb-2 text-lg font-bold text-gray-800">Bahan Segar</h3>
						<p class="text-sm text-gray-600">Semua bahan dipilih langsung dari pasar dengan standar kualitas terbaik.</p>
					</div>

					<div
						class="info-card group rounded-xl border-l-4 border-orange-500 bg-white p-6 shadow-lg transition-all duration-300 hover:border-orange-600 hover:shadow-xl">
						<div class="mb-3 text-4xl transition-transform group-hover:scale-110">⚡</div>
						<h3 class="mb-2 text-lg font-bold text-gray-800">Cepat & Higienis</h3>
						<p class="text-sm text-gray-600">Makanan disiapkan dengan cepat dengan standar kebersihan tertinggi.</p>
					</div>
				</div>

				<div class="mb-8 sm:mb-10">
					<p class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-600">Kategori</p>
					<div class="flex flex-wrap gap-2 sm:gap-3">
						<a href="{{ route('menu.public') }}"
							class="filter-btn {{ !$kategori ? 'active' : '' }} {{ !$kategori ? 'text-white shadow-lg' : 'bg-white text-slate-700 border-2 border-slate-200 hover:border-pink-400' }} rounded-full px-5 py-2.5 font-semibold transition sm:px-7"
							style="{{ !$kategori ? 'background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);' : '' }}">
							🎯 Semua Menu
						</a>
						@foreach ($kategoris as $kat)
							<a href="{{ route('menu.public', ['kategori' => $kat->nama_kategori]) }}"
								class="filter-btn {{ $kategori === $kat->nama_kategori ? 'active' : '' }} {{ $kategori === $kat->nama_kategori ? 'text-white shadow-lg' : 'bg-white text-slate-700 border-2 border-slate-200 hover:border-pink-400' }} rounded-full px-5 py-2.5 font-semibold transition sm:px-7"
								style="{{ $kategori === $kat->nama_kategori ? 'background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);' : '' }}">
								{{ $kat->nama_kategori === 'Makanan' ? '🍜' : '🥤' }} {{ $kat->nama_kategori }}
							</a>
						@endforeach
					</div>

					<!-- Menu Grid -->
					@if ($menus->count() > 0)
						<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
							@foreach ($menus as $menu)
								<div class="menu-card animate-scale-in group overflow-hidden rounded-2xl bg-white shadow-lg">
									<!-- Image Container -->
									<div class="relative h-52 overflow-hidden bg-gradient-to-br from-slate-200 to-slate-300">
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
										<h3 class="mb-2 line-clamp-2 text-lg font-bold text-slate-800">{{ $menu->nama_menu }}</h3>
										<p class="mb-3 text-xs text-slate-600">Kategori: <span class="font-semibold"
												style="color: #dc0080;">{{ $menu->kategori->nama_kategori }}</span></p>
										@if ($menu->deskripsi)
											<p class="mb-4 line-clamp-2 text-sm text-slate-600">{{ $menu->deskripsi }}</p>
										@endif

										<!-- Price -->
										<div class="mb-4 flex items-baseline gap-2">
											<span class="text-3xl font-bold text-amber-600">Rp
												{{ number_format($menu->harga / 1000, 0, ',', '.') }}</span>
											<span class="text-xs text-slate-500">/ porsi</span>
										</div>

										<!-- Add to Cart Form -->
										<form action="{{ route('cart.add', $menu->id_menu) }}" method="POST" class="mt-auto space-y-3">
											@csrf
											<div class="flex items-center gap-2">
												<input type="number" name="quantity" value="1" min="1" max="{{ $menu->stok }}"
													class="w-20 rounded-lg border-2 border-slate-300 px-3 py-2 text-sm font-semibold focus:outline-none"
													style="focus-border-color: #dc0080;">
												<button type="submit" {{ $menu->stok <= 0 ? 'disabled' : '' }}
													class="{{ $menu->stok <= 0 ? 'bg-slate-400 cursor-not-allowed' : 'active:scale-95' }} flex-1 rounded-lg py-2.5 font-bold text-white shadow-lg transition"
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
							class="rounded-2xl border-2 border-dashed border-slate-300 bg-gradient-to-b from-slate-100 to-slate-50 py-16 text-center shadow-sm">
							<p class="mb-4 text-5xl">🔍</p>
							<p class="mb-2 text-2xl font-bold text-slate-700">Belum ada menu tersedia</p>
							<p class="text-slate-600">Silakan pilih kategori lain atau periksa kembali nanti</p>
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
	</body>

</html>
