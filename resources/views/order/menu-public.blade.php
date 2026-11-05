<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Kedai Bang Nana</title>
    <meta name="description" content="Pesan menu lezat dari Kedai Bang Nana langsung dari meja Anda!">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #0f172a; }

        /* ── Hero ── */
        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1a0f2e 50%, #0f172a 100%);
            position: relative; overflow: hidden;
        }
        .hero-glow-1 {
            position: absolute; top: -30%; left: -10%;
            width: 600px; height: 600px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(236,72,153,.13) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute; bottom: -20%; right: 0;
            width: 450px; height: 450px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(139,92,246,.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Floating Cart FAB ── */
        .cart-fab {
            position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 100;
            transition: all .3s cubic-bezier(.4,0,.2,1);
        }
        .cart-fab:hover { transform: scale(1.1) translateY(-2px); }
        .cart-fab-badge {
            position: absolute; top: -8px; right: -8px;
            min-width: 22px; height: 22px; border-radius: 9999px;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: #fff; font-size: .65rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #0f172a;
        }

        /* ── Menu cards ── */
        .menu-card { transition: box-shadow .35s ease, border-color .35s ease; }
        .menu-card:hover {
            box-shadow: 0 24px 50px rgba(0,0,0,.35), 0 0 0 1px rgba(236,72,153,.18);
            border-color: rgba(236,72,153,.18) !important;
        }
        .menu-card .card-img img { transition: transform .5s ease; }
        .menu-card:hover .card-img img { transform: scale(1.08); }

        /* ── Qty stepper ── */
        .qty-btn {
            width: 28px; height: 28px; border-radius: 8px;
            background: rgba(148,163,184,.08);
            border: 1px solid rgba(148,163,184,.15);
            color: #94a3b8; font-size: 1.1rem;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all .2s ease; user-select: none; line-height: 1;
        }
        .qty-btn:hover { background: rgba(236,72,153,.18); border-color: rgba(236,72,153,.4); color: #f472b6; }
        .qty-num { width: 32px; text-align: center; background: transparent; border: none; color: #fff; font-weight: 700; font-size: .875rem; }
        .qty-num:focus { outline: none; }

        /* ── Filter pills ── */
        .pill {
            display: inline-flex; align-items: center; gap: .375rem;
            border-radius: 9999px; padding: .4rem 1.1rem;
            font-size: .8125rem; font-weight: 600;
            transition: all .22s ease; cursor: pointer; text-decoration: none;
        }
        .pill-on  { background: linear-gradient(135deg,#ec4899,#a855f7); color: #fff; box-shadow: 0 4px 14px rgba(236,72,153,.3); }
        .pill-off { background: rgba(30,41,59,.65); border: 1px solid rgba(148,163,184,.12); color: #94a3b8; }
        .pill-off:hover { background: rgba(30,41,59,.9); border-color: rgba(148,163,184,.25); color: #fff; }

        /* ── Stat cards ── */
        .stat-card { transition: transform .3s ease; position: relative; overflow: hidden; }
        .stat-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; }
        .sc1::after { background: linear-gradient(90deg,#10b981,#059669); }
        .sc2::after { background: linear-gradient(90deg,#ec4899,#db2777); }
        .sc3::after { background: linear-gradient(90deg,#f59e0b,#d97706); }
        .sc4::after { background: linear-gradient(90deg,#a855f7,#7c3aed); }
        .stat-card:hover { transform: translateY(-4px); }

        /* ── Search box ── */
        .search-box {
            background: rgba(30,41,59,.7);
            border: 1px solid rgba(148,163,184,.12);
            border-radius: .875rem;
            transition: box-shadow .2s ease, border-color .2s ease;
        }
        .search-box:focus-within { border-color: rgba(236,72,153,.4); box-shadow: 0 0 0 3px rgba(236,72,153,.12); }
        .search-box input { background: transparent; border: none; color: #e2e8f0; width: 100%; font-size: .875rem; }
        .search-box input::placeholder { color: #475569; }
        .search-box input:focus { outline: none; }

        /* ── Carousel ── */
        .c-track { transition: transform .55s cubic-bezier(.4,0,.2,1); }
        .c-dot { width: 8px; height: 8px; border-radius: 9999px; background: rgba(255,255,255,.28); transition: all .3s ease; cursor: pointer; }
        .c-dot.on { width: 26px; background: #fff; }
        .c-btn {
            width: 36px; height: 36px; border-radius: 9999px;
            background: rgba(15,23,42,.75); border: 1px solid rgba(255,255,255,.1);
            color: #fff; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all .2s ease;
        }
        .c-btn:hover { background: rgba(236,72,153,.35); border-color: rgba(236,72,153,.4); }

        /* ── Animations ── */
        @keyframes heroFadeUp { from { opacity: 0; transform: translateY(30px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes fadeUp     { from { opacity: 0; transform: translateY(22px); }            to { opacity: 1; transform: translateY(0); } }
        @keyframes glowPulse  { 0%,100% { box-shadow: 0 0 18px rgba(236,72,153,.3); } 50% { box-shadow: 0 0 36px rgba(236,72,153,.6); } }
        .hero-in   { animation: heroFadeUp .7s ease-out both; }
        .hero-in-d { animation: heroFadeUp .7s .15s ease-out both; }
        .fu1 { animation: fadeUp .5s .05s ease-out both; }
        .fu2 { animation: fadeUp .5s .10s ease-out both; }
        .fu3 { animation: fadeUp .5s .15s ease-out both; }
        .glow-pulse { animation: glowPulse 2.5s ease-in-out infinite; }

        /* ── Toast ── */
        #toast {
            position: fixed; bottom: 6rem; left: 50%;
            transform: translateX(-50%) translateY(70px);
            background: rgba(15,23,42,.96); border: 1px solid rgba(16,185,129,.35);
            color: #34d399; padding: .55rem 1.4rem; border-radius: 9999px;
            font-size: .8125rem; font-weight: 600; z-index: 300;
            transition: transform .38s cubic-bezier(.4,0,.2,1), opacity .38s ease;
            opacity: 0; pointer-events: none; white-space: nowrap;
        }
        #toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }

        /* ── Out of stock overlay ── */
        .oos-overlay {
            position: absolute; inset: 0; backdrop-filter: blur(2px);
            background: rgba(15,23,42,.6);
            display: flex; align-items: center; justify-content: center;
        }
    </style>
</head>

<body class="font-sans antialiased">

{{-- ══ STICKY HEADER ══ --}}
<header class="sticky top-0 z-50"
        style="background:rgba(15,23,42,.88);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border-bottom:1px solid rgba(148,163,184,.08);">
    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6">
        <div class="flex items-center justify-between gap-4">

            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Kedai Bang Nana" class="h-10 w-auto object-contain drop-shadow-[0_4px_12px_rgba(236,72,153,0.3)]">
                <div>
                    <p class="text-lg font-black leading-tight text-white">Kedai Bang <span class="text-gradient-primary">Nana</span></p>
                    <p class="hidden text-[10px] font-medium uppercase tracking-widest text-slate-600 sm:block">Self-Service Ordering</p>
                </div>
            </div>

            {{-- Desktop search --}}
            <div class="search-box hidden flex-1 max-w-sm sm:flex items-center gap-2 px-3 py-2.5">
                <svg class="h-4 w-4 flex-shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="searchDesktop" type="text" placeholder="Cari menu...">
            </div>

            {{-- Cart --}}
            <a href="{{ route('cart.view') }}"
               class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-white transition-all"
               style="background:rgba(236,72,153,.12);border:1px solid rgba(236,72,153,.25);">
                <svg class="h-5 w-5 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="font-bold text-pink-300">{{ count($cart) }}</span>
                <span class="hidden sm:inline text-slate-300">item</span>
            </a>
        </div>
    </div>
</header>

{{-- ══ HERO ══ --}}
<section class="hero-section px-4 py-16 text-center sm:py-24 sm:px-6">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    <div class="relative z-10 mx-auto max-w-3xl">
        <div class="hero-in mb-5 inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-widest"
             style="background:rgba(236,72,153,.1);border:1px solid rgba(236,72,153,.25);color:#f472b6;">
            <i data-lucide="flame" class="w-4 h-4 text-pink-400"></i>
            <span>Pesan langsung dari meja — Tanpa antri!</span>
        </div>
        <h2 class="hero-in mb-4 text-4xl font-black leading-tight tracking-tight text-white sm:text-6xl">
            Selamat Datang di<br>
            <span class="text-gradient-primary">Kedai Bang Nana</span>
        </h2>
        <p class="hero-in-d mx-auto max-w-xl text-base leading-relaxed text-slate-400 sm:text-lg">
            Pilih menu favoritmu, atur jumlah, dan langsung pesan. Cepat, mudah, dan lezat!
        </p>
        <div class="hero-in-d mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
            <a href="#menu-section" class="btn btn-primary group inline-flex items-center gap-2 px-7 py-3 text-base shadow-xl shadow-pink-500/25">
                <span>Lihat Menu</span>
                <i data-lucide="arrow-down" class="w-4 h-4 transition-transform group-hover:translate-y-0.5"></i>
            </a>
            <a href="{{ route('cart.view') }}" class="btn btn-ghost inline-flex items-center gap-2 px-7 py-3 text-base">
                <i data-lucide="shopping-cart" class="w-5 h-5 text-pink-400"></i>
                <span>Keranjang ({{ count($cart) }})</span>
            </a>
        </div>
    </div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-20 select-none"
         style="background:linear-gradient(to top,#0f172a,transparent);"></div>
</section>

{{-- ══ STAT CARDS ══ --}}
<div class="relative z-10 -mt-6 mx-auto max-w-7xl px-4 sm:px-6">
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 sm:gap-4">
        <div class="stat-card sc1 glass-card rounded-2xl p-4 text-center sm:p-5">
            <p class="text-2xl font-black text-emerald-400 sm:text-3xl">{{ $kategoris->count() }}</p>
            <p class="mt-1 text-xs font-medium text-slate-400">Kategori Menu</p>
        </div>
        <div class="stat-card sc2 glass-card rounded-2xl p-4 text-center sm:p-5">
            <p class="text-2xl font-black text-pink-400 sm:text-3xl">{{ $menus->total() }}+</p>
            <p class="mt-1 text-xs font-medium text-slate-400">Pilihan Menu</p>
        </div>
        <div class="stat-card sc3 glass-card rounded-2xl p-4 text-center sm:p-5">
            <p class="text-2xl font-black text-amber-400 sm:text-3xl flex items-center justify-center gap-1">
                <i data-lucide="star" class="w-5 h-5 fill-amber-400 text-amber-400"></i>
                <span>4.8</span>
            </p>
            <p class="mt-1 text-xs font-medium text-slate-400">Rating Pelanggan</p>
        </div>
        <div class="stat-card sc4 glass-card rounded-2xl p-4 text-center sm:p-5">
            <p class="text-2xl font-black text-violet-400 sm:text-3xl">&lt; 15'</p>
            <p class="mt-1 text-xs font-medium text-slate-400">Waktu Saji</p>
        </div>
    </div>
</div>

{{-- ══ CAROUSEL ══ --}}
<div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6">
    <div class="relative overflow-hidden rounded-2xl" style="border:1px solid rgba(148,163,184,.08);">
        <div id="cTrack" class="c-track flex">
            @php
                $slides = [
                    ['img' => 'images/image1.png', 'title' => 'Menu Pilihan Terbaik',    'sub' => 'Cita rasa istimewa yang tak terlupakan'],
                    ['img' => 'images/image2.png', 'title' => 'Minuman Segar & Nikmat',  'sub' => 'Menemani setiap momen santai Anda'],
                    ['img' => 'images/image3.png', 'title' => 'Promo Spesial Hari Ini!', 'sub' => 'Penawaran terbaik hanya untuk Anda'],
                ];
            @endphp
            @foreach ($slides as $sl)
            <div class="relative w-full flex-shrink-0">
                <img src="{{ asset($sl['img']) }}" alt="{{ $sl['title'] }}"
                     class="h-52 w-full object-cover sm:h-72"
                     onerror="this.parentElement.style.minHeight='200px';this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-6 sm:p-10">
                    <span class="mb-2 inline-block rounded-full px-3 py-1 text-[10px] font-bold uppercase tracking-wider"
                          style="background:rgba(236,72,153,.2);border:1px solid rgba(236,72,153,.35);color:#f472b6;">
                        Kedai Bang Nana
                    </span>
                    <h3 class="mt-2 text-2xl font-extrabold text-white sm:text-4xl">{{ $sl['title'] }}</h3>
                    <p class="mt-1 text-sm text-slate-300 sm:text-base">{{ $sl['sub'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="absolute bottom-4 right-5 flex gap-1.5" id="cDots">
            @foreach ($slides as $i => $_)
            <div class="c-dot {{ $i === 0 ? 'on' : '' }}" data-i="{{ $i }}"></div>
            @endforeach
        </div>
        <button id="cPrev" class="c-btn absolute left-3 top-1/2 -translate-y-1/2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button id="cNext" class="c-btn absolute right-3 top-1/2 -translate-y-1/2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<main class="mx-auto max-w-7xl flex-1 px-4 py-12 sm:px-6">

    {{-- Alerts --}}
    @if ($errors->any())
    <div class="mb-6 rounded-xl p-4" style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.2);">
        <p class="mb-2 font-semibold text-red-300">⚠️ Terjadi kesalahan:</p>
        <ul class="list-inside list-disc space-y-1 text-sm text-red-400">
            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
    <div id="alertOk" class="mb-6 flex items-center justify-between rounded-xl p-4"
         style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.2);">
        <div class="flex items-center gap-2 text-emerald-300">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('alertOk').remove()" class="text-emerald-400 hover:text-white">✕</button>
    </div>
    @endif

    {{-- Info cards --}}
    <div class="mb-14 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="fu1 group rounded-2xl p-5 transition-all duration-300 hover:-translate-y-1"
             style="background:rgba(236,72,153,.07);border:1px solid rgba(236,72,153,.14);">
            <div class="mb-3 text-pink-400 transition-transform duration-300 group-hover:scale-110">
                <i data-lucide="chef-hat" class="w-8 h-8"></i>
            </div>
            <h3 class="mb-1 font-bold text-white">Chef Berpengalaman</h3>
            <p class="text-sm leading-relaxed text-slate-400">Dimasak oleh chef profesional berpengalaman lebih dari 10 tahun.</p>
        </div>
        <div class="fu2 group rounded-2xl p-5 transition-all duration-300 hover:-translate-y-1"
             style="background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.14);">
            <div class="mb-3 text-emerald-400 transition-transform duration-300 group-hover:scale-110">
                <i data-lucide="salad" class="w-8 h-8"></i>
            </div>
            <h3 class="mb-1 font-bold text-white">Bahan Segar Setiap Hari</h3>
            <p class="text-sm leading-relaxed text-slate-400">Semua bahan pilihan langsung dari pasar dengan standar kualitas terbaik.</p>
        </div>
        <div class="fu3 group rounded-2xl p-5 transition-all duration-300 hover:-translate-y-1"
             style="background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.14);">
            <div class="mb-3 text-amber-400 transition-transform duration-300 group-hover:scale-110">
                <i data-lucide="zap" class="w-8 h-8"></i>
            </div>
            <h3 class="mb-1 font-bold text-white">Cepat &amp; Higienis</h3>
            <p class="text-sm leading-relaxed text-slate-400">Makanan disiapkan cepat dengan standar kebersihan tertinggi.</p>
        </div>
    </div>

    {{-- Filter + Search --}}
    <div class="mb-6" id="menu-section">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-extrabold text-white sm:text-2xl flex items-center gap-2">
                    <i data-lucide="utensils-crossed" class="w-6 h-6 text-pink-400"></i>
                    <span>Menu Kami</span>
                </h2>
                <p class="text-xs text-slate-500">{{ $menus->total() }} menu tersedia</p>
            </div>
            <div class="search-box flex sm:hidden items-center gap-2 px-3 py-2.5">
                <svg class="h-4 w-4 flex-shrink-0 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="searchMobile" type="text" placeholder="Cari menu...">
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('menu.public') }}" class="pill inline-flex items-center gap-1.5 {{ !$kategori ? 'pill-on' : 'pill-off' }}">
                <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
                <span>Semua Menu</span>
            </a>
            @foreach ($kategoris as $kat)
            <a href="{{ route('menu.public', ['kategori' => $kat->nama_kategori]) }}"
               class="pill inline-flex items-center gap-1.5 {{ $kategori === $kat->nama_kategori ? 'pill-on' : 'pill-off' }}">
                @if($kat->nama_kategori === 'Makanan')
                    <i data-lucide="utensils" class="w-3.5 h-3.5"></i>
                @elseif($kat->nama_kategori === 'Minuman')
                    <i data-lucide="coffee" class="w-3.5 h-3.5"></i>
                @else
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                @endif
                <span>{{ $kat->nama_kategori }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Menu Grid --}}
    @if ($menus->count() > 0)
    <div id="menuGrid" class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($menus as $menu)
        @php
            $sp = public_path('storage/' . $menu->foto);
            $up = public_path('uploads/'  . $menu->foto);
            if (file_exists($sp))      { $src = asset('storage/' . $menu->foto); }
            elseif (file_exists($up))  { $src = asset('uploads/'  . $menu->foto); }
            else { $src = 'https://placehold.co/400x300/1e293b/475569?text=' . urlencode($menu->nama_menu); }
            $ok = $menu->stok > 0;
        @endphp
        <div class="menu-card glass-card overflow-hidden rounded-2xl" data-name="{{ strtolower($menu->nama_menu) }}">
            <div class="card-img relative h-48 overflow-hidden">
                <img src="{{ $src }}" alt="{{ $menu->nama_menu }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute right-3 top-3">
                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold"
                          style="background:rgba(15,23,42,.8);border:1px solid rgba(148,163,184,.18);color:#cbd5e1;backdrop-filter:blur(8px);">
                        {{ $menu->kategori->nama_kategori === 'Makanan' ? '🍜' : '🥤' }} {{ $menu->kategori->nama_kategori }}
                    </span>
                </div>
                <div class="absolute bottom-3 left-3">
                    @if ($ok)
                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold"
                          style="background:rgba(16,185,129,.18);border:1px solid rgba(16,185,129,.3);color:#34d399;">
                        ✓ {{ $menu->stok }} tersedia
                    </span>
                    @else
                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold"
                          style="background:rgba(239,68,68,.18);border:1px solid rgba(239,68,68,.3);color:#f87171;">
                        ✕ Habis
                    </span>
                    @endif
                </div>
                @if (!$ok)
                <div class="oos-overlay">
                    <span class="rounded-full px-4 py-1.5 text-sm font-bold text-white"
                          style="background:rgba(239,68,68,.28);border:1px solid rgba(239,68,68,.45);">
                        Stok Habis
                    </span>
                </div>
                @endif
            </div>
            <div class="flex flex-col p-4">
                <h3 class="mb-1 line-clamp-1 text-base font-bold text-white">{{ $menu->nama_menu }}</h3>
                @if ($menu->deskripsi)
                <p class="mb-3 line-clamp-2 text-xs leading-relaxed text-slate-500">{{ $menu->deskripsi }}</p>
                @else
                <div class="mb-3"></div>
                @endif
                <div class="mb-4 flex items-baseline gap-1">
                    <span class="text-xl font-extrabold text-amber-400">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                    <span class="text-[11px] text-slate-600">/ porsi</span>
                </div>
                @if ($ok)
                <form action="{{ route('cart.add', $menu->id_menu) }}" method="POST" class="mt-auto cart-form">
                    @csrf
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-0.5 rounded-xl px-2 py-1.5"
                             style="background:rgba(30,41,59,.8);border:1px solid rgba(148,163,184,.12);">
                            <button type="button" class="qty-btn qm">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $menu->stok }}" class="qty-num" readonly>
                            <button type="button" class="qty-btn qp">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary flex-1 py-2 text-sm shadow-md shadow-pink-500/20 add-btn inline-flex items-center justify-center gap-1.5">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                </form>
                @else
                <button disabled class="btn w-full py-2 text-sm cursor-not-allowed"
                        style="background:rgba(51,65,85,.45);color:#475569;">Stok Habis</button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-12 flex justify-center">{{ $menus->links() }}</div>
    @else
    <div class="rounded-2xl py-20 text-center" style="background:rgba(30,41,59,.28);border:1px solid rgba(148,163,184,.08);">
        <div class="flex justify-center mb-4">
            <i data-lucide="search-x" class="w-16 h-16 text-slate-500"></i>
        </div>
        <p class="mb-2 text-xl font-bold text-white">Belum ada menu tersedia</p>
        <p class="text-sm text-slate-400">Coba pilih kategori lain atau periksa kembali nanti</p>
        <a href="{{ route('menu.public') }}" class="btn btn-primary mt-6 inline-flex items-center gap-2 px-6 py-2.5 text-sm">
            <i data-lucide="utensils" class="w-4 h-4"></i>
            <span>Lihat Semua Menu</span>
        </a>
    </div>
    @endif
</main>

{{-- ══ FOOTER ══ --}}
<footer class="mt-8 pb-24 sm:pb-8" style="background:rgba(15,23,42,.85);border-top:1px solid rgba(148,163,184,.07);">
    <div class="mx-auto max-w-7xl px-4 py-8 text-center sm:px-6">
        <div class="mb-3 flex items-center justify-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Kedai Bang Nana" class="h-8 w-auto object-contain">
            <span class="font-bold text-white">Kedai Bang Nana</span>
        </div>
        <p class="text-sm text-slate-500">© 2026 Kedai Bang Nana · Semua hak cipta dilindungi.</p>
        <p class="mt-1 text-xs text-slate-600">Terima kasih telah mempercayai kami 🙏</p>
    </div>
</footer>

{{-- Floating Cart (Mobile only) --}}
<div class="cart-fab sm:hidden">
    <a href="{{ route('cart.view') }}"
       class="glow-pulse flex h-14 w-14 items-center justify-center rounded-full shadow-2xl shadow-pink-500/40"
       style="background:linear-gradient(135deg,#ec4899,#db2777);">
        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        @if (count($cart) > 0)
        <span class="cart-fab-badge">{{ count($cart) }}</span>
        @endif
    </a>
</div>

{{-- Toast --}}
<div id="toast">✅ Ditambahkan ke keranjang!</div>

<script>
/* ── Carousel ── */
(function(){
    var track = document.getElementById('cTrack'),
        dots  = document.querySelectorAll('.c-dot'),
        prev  = document.getElementById('cPrev'),
        next  = document.getElementById('cNext');
    if (!track) return;
    var idx = 0, total = dots.length, tmr;
    function go(n, m) {
        idx = ((n % total) + total) % total;
        track.style.transform = 'translateX(-' + (idx * 100) + '%)';
        dots.forEach(function(d, i) { d.classList.toggle('on', i === idx); });
        if (m) { clearInterval(tmr); start(); }
    }
    function start() { tmr = setInterval(function() { go(idx + 1); }, 3600); }
    dots.forEach(function(d, i) { d.addEventListener('click', function() { go(i, true); }); });
    prev.addEventListener('click', function() { go(idx - 1, true); });
    next.addEventListener('click', function() { go(idx + 1, true); });
    go(0); start();
})();

/* ── Qty stepper ── */
document.querySelectorAll('.cart-form').forEach(function(form) {
    var inp = form.querySelector('.qty-num');
    var mx  = parseInt(inp.max) || 99;
    form.querySelector('.qm').addEventListener('click', function() { if (parseInt(inp.value) > 1) inp.value--; });
    form.querySelector('.qp').addEventListener('click', function() { if (parseInt(inp.value) < mx) inp.value++; });
    form.addEventListener('submit', function() {
        var btn = form.querySelector('.add-btn');
        btn.textContent = '✅ Ditambahkan!';
        btn.disabled = true;
        showToast();
        setTimeout(function() { btn.innerHTML = '🛒 Tambah'; btn.disabled = false; }, 1600);
    });
});

/* ── Toast ── */
function showToast() {
    var t = document.getElementById('toast');
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(function() { t.classList.remove('show'); }, 2600);
}

/* ── Live search ── */
function bindSearch(id) {
    var el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        document.querySelectorAll('#menuGrid .menu-card').forEach(function(c) {
            c.style.display = (!q || c.dataset.name.includes(q)) ? '' : 'none';
        });
        ['searchDesktop', 'searchMobile'].forEach(function(s) {
            if (s !== id) { var o = document.getElementById(s); if (o) o.value = q; }
        });
    });
}
bindSearch('searchDesktop');
bindSearch('searchMobile');

/* ── Scroll reveal ── */
var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
        if (e.isIntersecting) {
            e.target.style.opacity = '1';
            e.target.style.transform = 'translateY(0)';
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.08 });

document.querySelectorAll('.menu-card').forEach(function(el, i) {
    el.style.opacity    = '0';
    el.style.transform  = 'translateY(24px)';
    el.style.transition = 'opacity .5s ' + (i * 0.05) + 's ease, transform .5s ' + (i * 0.05) + 's ease, box-shadow .35s ease, border-color .35s ease';
    observer.observe(el);
});

/* ── Init Lucide Icons ── */
if (window.lucide) {
    lucide.createIcons();
}
</script>
</body>
</html>