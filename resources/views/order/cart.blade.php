<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Pesanan - Kedai Bang Nana</title>
    <meta name="description" content="Periksa dan atur keranjang pesanan Anda di Kedai Bang Nana.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #0f172a; }

        /* Ambient Glows */
        .cart-glow-1 {
            position: absolute; top: -10%; left: -5%;
            width: 500px; height: 500px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(236,72,153,.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .cart-glow-2 {
            position: absolute; top: 40%; right: -10%;
            width: 450px; height: 450px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(139,92,246,.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Glass Cards */
        .cart-glass {
            background: rgba(30, 41, 59, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }
        .cart-glass-highlight {
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(236, 72, 153, 0.25);
            box-shadow: 0 10px 30px -10px rgba(236, 72, 153, 0.15);
        }

        /* Qty Stepper */
        .cart-qty-btn {
            width: 32px; height: 32px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
            font-size: 1rem;
            font-weight: 700;
            transition: all 0.2s ease;
            user-select: none;
        }
        .cart-qty-btn:hover:not(:disabled) {
            background: rgba(236, 72, 153, 0.2);
            border-color: rgba(236, 72, 153, 0.4);
            color: #f472b6;
            transform: translateY(-1px);
        }
        .cart-qty-btn:active:not(:disabled) {
            transform: scale(0.95);
        }
        .cart-qty-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Toast animation */
        .toast-notify {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .toast-notify.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Item Row Animation */
        .cart-item-row {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cart-item-row.removing {
            opacity: 0;
            transform: scale(0.95) translateX(-20px);
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
            margin: 0;
            overflow: hidden;
        }

        /* Mobile Bottom Sticky Bar */
        .mobile-checkout-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 40;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(148, 163, 184, 0.15);
            padding: 0.85rem 1rem;
            box-shadow: 0 -8px 25px rgba(0,0,0,0.4);
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-100 min-h-screen flex flex-col relative overflow-x-hidden selection:bg-pink-500 selection:text-white">

    <!-- Background Glows -->
    <div class="cart-glow-1"></div>
    <div class="cart-glow-2"></div>

    <!-- Header -->
    <header class="sticky top-0 z-50 glass-strong border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <a href="{{ route('menu.public') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Kedai Bang Nana" class="h-10 w-auto object-contain drop-shadow-[0_4px_12px_rgba(236,72,153,0.3)] group-hover:scale-105 transition duration-300">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-extrabold text-white tracking-tight">Kedai Bang <span class="text-gradient-primary">Nana</span></span>
                        <span class="hidden sm:inline-flex px-2 py-0.5 text-[10px] font-bold rounded-full bg-pink-500/10 text-pink-400 border border-pink-500/20">Self-Order</span>
                    </div>
                    <p class="text-[11px] text-slate-400">Café & Resto • Rasanya Bikin Nagih</p>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('menu.public') }}" class="btn btn-ghost text-sm inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 border border-white/5">
                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Tambah Menu Lagi</span>
                    <span class="sm:hidden">Menu</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Progress Stepper -->
    <div class="border-b border-white/5 bg-slate-900/60 backdrop-blur-md">
        <div class="max-w-4xl mx-auto px-4 py-4 sm:py-5">
            <div class="flex items-center justify-between relative">
                <!-- Step 1: Keranjang (Active) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl gradient-primary flex items-center justify-center font-bold text-white shadow-lg shadow-pink-500/30 ring-2 ring-pink-500/40">
                        <i data-lucide="shopping-cart" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-pink-400 font-bold block">Langkah 1</span>
                        <span class="text-xs sm:text-sm font-bold text-white">Keranjang</span>
                    </div>
                </div>

                <!-- Connector Line 1-2 -->
                <div class="flex-1 mx-3 sm:mx-6 h-0.5 bg-gradient-to-r from-pink-500/60 to-slate-700/60 rounded"></div>

                <!-- Step 2: Checkout (Upcoming) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10 opacity-60">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-800 border border-white/10 flex items-center justify-center font-bold text-slate-400">
                        <i data-lucide="clipboard-pen" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-[10px] uppercase tracking-wider text-slate-400 font-medium block">Langkah 2</span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-300">Data Pemesan</span>
                    </div>
                </div>

                <!-- Connector Line 2-3 -->
                <div class="flex-1 mx-3 sm:mx-6 h-0.5 bg-slate-800 rounded"></div>

                <!-- Step 3: Payment (Upcoming) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10 opacity-40">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-800/80 border border-white/5 flex items-center justify-center font-bold text-slate-400">
                        <i data-lucide="credit-card" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 font-medium block">Langkah 3</span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-400">Pembayaran</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 pb-28 sm:pb-12">

        <!-- Flash Messages -->
        @if (session('success'))
            <div id="flash-alert" class="mb-6 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 backdrop-blur-md p-4 text-sm text-emerald-300 flex items-center justify-between shadow-lg shadow-emerald-950/40">
                <div class="flex items-center gap-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-300">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('flash-alert').remove()" class="text-emerald-400 hover:text-white p-1 rounded-lg">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div id="flash-error" class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 backdrop-blur-md p-4 text-sm text-red-300 flex items-center justify-between shadow-lg shadow-red-950/40">
                <div class="flex items-center gap-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-500/20 text-red-300">
                        <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    </span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('flash-error').remove()" class="text-red-400 hover:text-white p-1 rounded-lg">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if (count($cart) > 0)
            @php
                $itemCount = 0;
                $computedGrandTotal = 0;
                foreach ($cart as $it) {
                    $itemCount += $it['quantity'];
                    $computedGrandTotal += $it['harga'] * $it['quantity'];
                }
            @endphp

            <!-- Title & Quick Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Keranjang Pesanan</h1>
                        <span id="badge-total-items" class="px-3 py-1 rounded-full text-xs font-bold bg-pink-500/20 text-pink-300 border border-pink-500/30">
                            {{ $itemCount }} porsi
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1">Periksa menu pilihan Anda dan tentukan jumlah sebelum lanjut ke formulir pemesan.</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('menu.public') }}" class="btn btn-ghost text-xs sm:text-sm px-4 py-2.5 rounded-xl border border-white/10 hover:border-pink-500/30 hover:bg-white/5 text-slate-300 flex items-center gap-1.5 transition">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        <span>Tambah Menu Lain</span>
                    </a>
                    <button type="button" onclick="openClearModal()" class="btn text-xs sm:text-sm px-3.5 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 flex items-center gap-1.5 transition">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Kosongkan</span>
                    </button>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left Column: Items List (8 cols) -->
                <div class="lg:col-span-7 xl:col-span-8 space-y-4">

                    <!-- Desktop & Tablet Card Container -->
                    <div class="cart-glass rounded-2xl overflow-hidden shadow-xl border border-white/10">
                        <div class="hidden md:grid grid-cols-12 px-6 py-3.5 bg-slate-900/80 border-b border-white/5 text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <div class="col-span-6">Menu & Detail</div>
                            <div class="col-span-2 text-right">Harga</div>
                            <div class="col-span-2 text-center">Jumlah</div>
                            <div class="col-span-2 text-right">Subtotal</div>
                        </div>

                        <div class="divide-y divide-white/5" id="cart-items-container">
                            @foreach ($cart as $menuId => $item)
                                @php
                                    $itemSubtotal = $item['harga'] * $item['quantity'];
                                @endphp
                                <div class="cart-item-row p-4 sm:p-5 hover:bg-white/[0.02]" id="cart-item-{{ $menuId }}" data-menu-id="{{ $menuId }}" data-price="{{ $item['harga'] }}">
                                    <!-- Desktop View (md+) -->
                                    <div class="hidden md:grid grid-cols-12 items-center gap-4">
                                        <!-- Menu info (col 6) -->
                                        <div class="col-span-6 flex items-center gap-3.5">
                                            <div class="relative w-16 h-16 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 ring-1 ring-white/10">
                                                @if(!empty($item['foto']))
                                                    <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_menu'] }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&auto=format&fit=crop&q=80'">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-2xl bg-gradient-to-br from-pink-500/20 to-purple-500/20 text-pink-400">🍲</div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3 class="font-bold text-white text-base truncate">{{ $item['nama_menu'] }}</h3>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-xs text-slate-400">@ Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-md bg-white/5 text-slate-300">Siap Dibuat</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Harga Satuan (col 2) -->
                                        <div class="col-span-2 text-right">
                                            <span class="text-sm font-semibold text-slate-300">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                        </div>

                                        <!-- Stepper Qty (col 2) -->
                                        <div class="col-span-2 flex items-center justify-center">
                                            <div class="inline-flex items-center gap-1.5 bg-slate-900/90 p-1 rounded-xl border border-white/10">
                                                <button type="button" class="cart-qty-btn" onclick="updateQty('{{ $menuId }}', -1)" title="Kurang 1">
                                                    −
                                                </button>
                                                <span class="w-8 text-center font-bold text-sm text-white qty-display-{{ $menuId }}">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button type="button" class="cart-qty-btn" onclick="updateQty('{{ $menuId }}', 1)" title="Tambah 1">
                                                    +
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Subtotal + Delete (col 2) -->
                                        <div class="col-span-2 text-right flex items-center justify-end gap-3">
                                            <div class="text-right">
                                                <div class="text-sm font-bold text-pink-400 subtotal-display-{{ $menuId }}">
                                                    Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <button type="button" onclick="confirmRemoveItem('{{ $menuId }}', '{{ addslashes($item['nama_menu']) }}')" class="p-1.5 rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition" title="Hapus item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Mobile View (< md) -->
                                    <div class="md:hidden flex gap-3.5">
                                        <div class="relative w-20 h-20 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 ring-1 ring-white/10">
                                            @if(!empty($item['foto']))
                                                <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_menu'] }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&auto=format&fit=crop&q=80'">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-3xl bg-gradient-to-br from-pink-500/20 to-purple-500/20 text-pink-400">🍲</div>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                                            <div class="flex items-start justify-between gap-2">
                                                <div>
                                                    <h3 class="font-bold text-white text-sm line-clamp-1">{{ $item['nama_menu'] }}</h3>
                                                    <p class="text-xs text-slate-400 mt-0.5">Rp {{ number_format($item['harga'], 0, ',', '.') }}/porsi</p>
                                                </div>
                                                <button type="button" onclick="confirmRemoveItem('{{ $menuId }}', '{{ addslashes($item['nama_menu']) }}')" class="p-1 rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition" title="Hapus item">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="flex items-center justify-between mt-3 pt-2 border-t border-white/5">
                                                <!-- Stepper -->
                                                <div class="inline-flex items-center gap-1.5 bg-slate-900/90 p-1 rounded-xl border border-white/10">
                                                    <button type="button" class="cart-qty-btn" onclick="updateQty('{{ $menuId }}', -1)">−</button>
                                                    <span class="w-6 text-center font-bold text-xs text-white qty-display-{{ $menuId }}">
                                                        {{ $item['quantity'] }}
                                                    </span>
                                                    <button type="button" class="cart-qty-btn" onclick="updateQty('{{ $menuId }}', 1)">+</button>
                                                </div>

                                                <!-- Subtotal -->
                                                <div class="text-right">
                                                    <span class="text-[10px] text-slate-400 block">Subtotal</span>
                                                    <span class="text-sm font-bold text-pink-400 subtotal-display-{{ $menuId }}">
                                                        Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fallback hidden form for non-js -->
                                    <noscript>
                                        <div class="mt-2 flex items-center justify-end gap-2">
                                            <form action="{{ route('cart.update', $menuId) }}" method="POST" class="inline-flex items-center gap-1">
                                                @csrf @method('PATCH')
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-14 px-2 py-1 bg-slate-900 rounded border border-white/20 text-xs text-white">
                                                <button type="submit" class="btn text-xs px-2 py-1 bg-white/10 text-white rounded">Update</button>
                                            </form>
                                            <form action="{{ route('cart.remove', $menuId) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn text-xs px-2 py-1 bg-red-500/20 text-red-400 rounded">Hapus</button>
                                            </form>
                                        </div>
                                    </noscript>
                                </div>
                            @endforeach
                        </div>

                        <!-- Card Footer Info -->
                        <div class="p-4 bg-slate-900/50 border-t border-white/5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-400">
                            <div class="flex items-center gap-2">
                                <i data-lucide="sparkles" class="w-4 h-4 text-pink-400 flex-shrink-0"></i>
                                <span>Porsi atau catatan khusus dapat disesuaikan pada saat konfirmasi pesanan.</span>
                            </div>
                            <a href="{{ route('menu.public') }}" class="text-pink-400 hover:text-pink-300 font-medium inline-flex items-center gap-1 transition">
                                <span>+ Tambah item menu</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Trust Cards below items list -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                        <div class="cart-glass rounded-xl p-3.5 flex items-center gap-3 border border-white/5">
                            <div class="h-9 w-9 rounded-lg bg-pink-500/10 text-pink-400 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="zap" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Proses Cepat</p>
                                <p class="text-[11px] text-slate-400">Langsung dikirim ke dapur</p>
                            </div>
                        </div>

                        <div class="cart-glass rounded-xl p-3.5 flex items-center gap-3 border border-white/5">
                            <div class="h-9 w-9 rounded-lg bg-violet-500/10 text-violet-400 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="chef-hat" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Fresh & Higienis</p>
                                <p class="text-[11px] text-slate-400">Bahan pilihan berkualitas</p>
                            </div>
                        </div>

                        <div class="cart-glass rounded-xl p-3.5 flex items-center gap-3 border border-white/5">
                            <div class="h-9 w-9 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Multi Pembayaran</p>
                                <p class="text-[11px] text-slate-400">QRIS, Transfer & Tunai</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Sticky Summary (4 cols) -->
                <div class="lg:col-span-5 xl:col-span-4 lg:sticky lg:top-24 space-y-4">

                    <!-- Summary Card -->
                    <div class="cart-glass-highlight rounded-2xl p-6 relative overflow-hidden">
                        <!-- Decorative gradient aura -->
                        <div class="absolute -top-12 -right-12 w-36 h-36 bg-pink-500/20 rounded-full blur-2xl pointer-events-none"></div>

                        <h2 class="text-lg font-bold text-white flex items-center gap-2 mb-5">
                            <i data-lucide="receipt" class="w-5 h-5 text-pink-400"></i>
                            <span>Ringkasan Pesanan</span>
                        </h2>

                        <!-- Breakdown details -->
                        <div class="space-y-3.5 border-b border-white/10 pb-5 text-sm">
                            <div class="flex items-center justify-between text-slate-300">
                                <span class="flex items-center gap-2">
                                    <span>Total Porsi</span>
                                </span>
                                <span class="font-semibold text-white" id="summary-portions">{{ $itemCount }} porsi</span>
                            </div>

                            <div class="flex items-center justify-between text-slate-300">
                                <span>Subtotal Menu</span>
                                <span class="font-semibold text-white" id="summary-subtotal">Rp {{ number_format($computedGrandTotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex items-center justify-between text-slate-300">
                                <span class="flex items-center gap-1.5">
                                    <span>Pajak & Pelayanan</span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-medium">Termasuk</span>
                                </span>
                                <span class="font-semibold text-emerald-400">Gratis (Rp 0)</span>
                            </div>
                        </div>

                        <!-- Grand Total -->
                        <div class="py-5 border-b border-white/10">
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block">Total Pembayaran</span>
                                    <span class="text-[11px] text-slate-500">Harga final yang dibayar</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-300 tracking-tight" id="summary-grandtotal">
                                        Rp {{ number_format($computedGrandTotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Action Buttons -->
                        <div class="mt-6 space-y-3">
                            <a href="{{ route('order.checkout') }}" class="btn btn-primary w-full py-3.5 rounded-xl font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-pink-500/25 hover:shadow-pink-500/40 transform hover:-translate-y-0.5 transition duration-200">
                                <span>Lanjut ke Formulir Checkout</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>

                            <a href="{{ route('menu.public') }}" class="btn btn-ghost w-full py-3 rounded-xl text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/5 border border-white/10 flex items-center justify-center gap-2 transition">
                                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                <span>Pilih Menu Lainnya</span>
                            </a>
                        </div>

                        <!-- Security & Guarantee -->
                        <div class="mt-6 pt-4 border-t border-white/5 space-y-2 text-center text-xs text-slate-400">
                            <div class="flex items-center justify-center gap-2 text-slate-400">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Transaksi Aman & Terverifikasi</span>
                            </div>
                            <p class="text-[11px] text-slate-500">Mendukung Pembayaran QRIS (GoPay, OVO, ShopeePay, BCA) & Bayar di Kasir.</p>
                        </div>
                    </div>

                    <!-- Dine-in / Take Away notice badge -->
                    <div class="cart-glass rounded-xl p-4 border border-white/5 flex items-start gap-3">
                        <span class="text-xl">🪑</span>
                        <div class="text-xs">
                            <p class="font-bold text-slate-200">Makan di Tempat atau Bungkus?</p>
                            <p class="text-slate-400 mt-0.5">Tipe pesanan & nomor meja akan dipilih pada langkah berikutnya di halaman checkout.</p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Sticky Mobile Bottom Checkout Bar -->
            <div class="mobile-checkout-bar sm:hidden flex items-center justify-between gap-3">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Total Pesanan</span>
                    <span class="text-lg font-black text-pink-400" id="mobile-summary-total">
                        Rp {{ number_format($computedGrandTotal, 0, ',', '.') }}
                    </span>
                </div>
                <a href="{{ route('order.checkout') }}" class="btn btn-primary px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-lg shadow-pink-500/20">
                    <span>Checkout (<span id="mobile-summary-count">{{ $itemCount }}</span>)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        @else

            <!-- Empty Cart State -->
            <div class="max-w-xl mx-auto py-12 text-center animate-fade-in-up">
                <div class="cart-glass rounded-3xl p-8 sm:p-12 relative overflow-hidden border border-white/10 shadow-2xl">
                    <!-- Glow background -->
                    <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-64 bg-pink-500/20 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Animated cart icon illustration -->
                    <div class="relative w-24 h-24 mx-auto mb-6 flex items-center justify-center rounded-3xl bg-gradient-to-br from-pink-500/20 to-purple-500/20 border border-pink-500/30 text-pink-400 shadow-xl shadow-pink-500/10">
                        <i data-lucide="shopping-cart" class="w-12 h-12"></i>
                        <span class="absolute -top-1 -right-1 flex h-4 w-4">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-4 w-4 bg-pink-500"></span>
                        </span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Keranjang Anda Masih Kosong</h2>
                    <p class="mt-3 text-sm text-slate-400 leading-relaxed max-w-md mx-auto">
                        Sepertinya Anda belum memilih hidangan apapun. Yuk, jelajahi aneka menu lezat dan minuman segar spesial kami!
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('menu.public') }}" class="btn btn-primary w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-pink-500/25 hover:shadow-pink-500/40 transform hover:-translate-y-0.5 transition duration-200">
                            <i data-lucide="utensils" class="w-4 h-4"></i>
                            <span>Lihat Daftar Menu Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <!-- Mini recommendations / highlight perks -->
                    <div class="mt-10 pt-8 border-t border-white/10 grid grid-cols-3 gap-2 text-center">
                        <div class="p-2">
                            <div class="flex justify-center mb-1">
                                <i data-lucide="sparkles" class="w-6 h-6 text-pink-400"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-300 block">Olahan Pisang Juara</span>
                        </div>
                        <div class="p-2">
                            <div class="flex justify-center mb-1">
                                <i data-lucide="coffee" class="w-6 h-6 text-pink-400"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-300 block">Kopi & Minuman Segar</span>
                        </div>
                        <div class="p-2">
                            <div class="flex justify-center mb-1">
                                <i data-lucide="badge-percent" class="w-6 h-6 text-pink-400"></i>
                            </div>
                            <span class="text-xs font-semibold text-slate-300 block">Harga Terjangkau</span>
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </main>

    <!-- Footer -->
    <footer class="glass border-t border-white/5 py-6 text-center text-xs text-slate-500 mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Kedai Bang Nana" class="h-6 w-auto object-contain">
                <span class="font-semibold text-slate-400">Kedai Bang Nana</span>
                <span>• Sistem Kasir & Self-Order</span>
            </div>
            <p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Custom Modal: Konfirmasi Hapus Satu Item -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 hidden">
        <div class="cart-glass rounded-2xl max-w-md w-full p-6 border border-white/10 shadow-2xl animate-fade-in-up">
            <div class="w-12 h-12 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center mb-4">
                <i data-lucide="trash-2" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-white">Hapus Menu Ini?</h3>
            <p class="text-sm text-slate-400 mt-1" id="delete-modal-text">Apakah Anda yakin ingin menghapus menu ini dari keranjang belanja?</p>
            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()" class="btn btn-ghost text-sm px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">
                    Batal
                </button>
                <button type="button" id="confirm-delete-btn" class="btn text-sm px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold shadow-lg shadow-red-600/30">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Custom Modal: Konfirmasi Kosongkan Seluruh Keranjang -->
    <div id="clear-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 hidden">
        <div class="cart-glass rounded-2xl max-w-md w-full p-6 border border-white/10 shadow-2xl animate-fade-in-up">
            <div class="w-12 h-12 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center mb-4">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>
            <h3 class="text-lg font-bold text-white">Kosongkan Seluruh Keranjang?</h3>
            <p class="text-sm text-slate-400 mt-1">Semua menu yang telah Anda pilih akan dihapus dari daftar pesanan.</p>
            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" onclick="closeClearModal()" class="btn btn-ghost text-sm px-4 py-2 rounded-xl text-slate-300 hover:bg-white/5">
                    Batal
                </button>
                <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn text-sm px-4 py-2 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold shadow-lg shadow-red-600/30">
                        Kosongkan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Toast Notification -->
    <div id="cart-toast" class="toast-notify cart-glass rounded-2xl px-5 py-3.5 border border-pink-500/30 shadow-2xl flex items-center gap-3">
        <div class="w-7 h-7 rounded-lg bg-pink-500/20 text-pink-400 flex items-center justify-center text-sm font-bold" id="toast-icon">
            <i data-lucide="check" class="w-4 h-4"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-white" id="toast-title">Keranjang Diperbarui</p>
            <p class="text-[11px] text-slate-400" id="toast-message">Perubahan berhasil disimpan</p>
        </div>
    </div>

    <!-- JavaScript Interactive Handlers -->
    <script>
        if (window.lucide) {
            lucide.createIcons();
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        let pendingDeleteMenuId = null;

        // Toast Helper
        function showToast(title, message, isError = false) {
            const toast = document.getElementById('cart-toast');
            const toastTitle = document.getElementById('toast-title');
            const toastMsg = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');

            if (!toast) return;

            toastTitle.textContent = title;
            toastMsg.textContent = message;

            if (isError) {
                toastIcon.textContent = '✕';
                toastIcon.className = 'w-7 h-7 rounded-lg bg-red-500/20 text-red-400 flex items-center justify-center text-sm font-bold';
                toast.style.borderColor = 'rgba(239, 68, 68, 0.4)';
            } else {
                toastIcon.textContent = '✓';
                toastIcon.className = 'w-7 h-7 rounded-lg bg-pink-500/20 text-pink-400 flex items-center justify-center text-sm font-bold';
                toast.style.borderColor = 'rgba(236, 72, 153, 0.4)';
            }

            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Update Quantity via AJAX
        async function updateQty(menuId, delta) {
            const displays = document.querySelectorAll(`.qty-display-${menuId}`);
            if (!displays.length) return;

            const currentQty = parseInt(displays[0].textContent.trim()) || 1;
            const newQty = currentQty + delta;

            if (newQty <= 0) {
                // Konfirmasi hapus jika turun ke 0
                const itemRow = document.getElementById(`cart-item-${menuId}`);
                const itemName = itemRow ? itemRow.querySelector('h3')?.textContent : 'menu ini';
                confirmRemoveItem(menuId, itemName);
                return;
            }

            // Optimistic UI update
            displays.forEach(el => el.textContent = newQty);

            try {
                const response = await fetch(`/cart/update/${menuId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ quantity: newQty })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Update Subtotal on Item
                    document.querySelectorAll(`.subtotal-display-${menuId}`).forEach(el => {
                        el.textContent = data.subtotal_formatted;
                    });

                    // Update Summary
                    updateSummaryTotals(data);
                    showToast('Jumlah Diperbarui', data.message || 'Porsi berhasil diubah');
                } else {
                    // Revert on error
                    displays.forEach(el => el.textContent = currentQty);
                    showToast('Gagal Memperbarui', data.message || 'Terjadi kesalahan', true);
                }
            } catch (err) {
                console.error(err);
                displays.forEach(el => el.textContent = currentQty);
                showToast('Koneksi Gagal', 'Silakan periksa koneksi internet Anda', true);
            }
        }

        // Remove Item Modal Handlers
        function confirmRemoveItem(menuId, menuName) {
            pendingDeleteMenuId = menuId;
            const modal = document.getElementById('delete-modal');
            const textEl = document.getElementById('delete-modal-text');
            if (textEl && menuName) {
                textEl.textContent = `Hapus "${menuName}" dari keranjang belanja Anda?`;
            }
            if (modal) modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            pendingDeleteMenuId = null;
            const modal = document.getElementById('delete-modal');
            if (modal) modal.classList.add('hidden');
        }

        document.getElementById('confirm-delete-btn')?.addEventListener('click', async function() {
            if (!pendingDeleteMenuId) return;
            const menuId = pendingDeleteMenuId;
            closeDeleteModal();

            const itemRow = document.getElementById(`cart-item-${menuId}`);
            if (itemRow) {
                itemRow.classList.add('removing');
            }

            try {
                const response = await fetch(`/cart/remove/${menuId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    setTimeout(() => {
                        itemRow?.remove();
                        // If cart is now empty, reload page to show fresh empty state
                        if (data.cart_count === 0) {
                            window.location.reload();
                        } else {
                            updateSummaryTotals(data);
                            showToast('Menu Dihapus', data.message || 'Menu berhasil dihapus dari keranjang');
                        }
                    }, 300);
                } else {
                    itemRow?.classList.remove('removing');
                    showToast('Gagal Menghapus', 'Item gagal dihapus', true);
                }
            } catch (err) {
                console.error(err);
                itemRow?.classList.remove('removing');
                showToast('Koneksi Gagal', 'Gagal menghubungi server', true);
            }
        });

        // Clear Cart Modal
        function openClearModal() {
            const modal = document.getElementById('clear-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeClearModal() {
            const modal = document.getElementById('clear-modal');
            if (modal) modal.classList.add('hidden');
        }

        // Close modal on click backdrop
        window.addEventListener('click', function(e) {
            const delModal = document.getElementById('delete-modal');
            const clrModal = document.getElementById('clear-modal');
            if (e.target === delModal) closeDeleteModal();
            if (e.target === clrModal) closeClearModal();
        });

        // Helper to update sidebar and mobile summary
        function updateSummaryTotals(data) {
            if (data.total_formatted) {
                const subtotalEl = document.getElementById('summary-subtotal');
                const grandtotalEl = document.getElementById('summary-grandtotal');
                const mobileTotalEl = document.getElementById('mobile-summary-total');

                if (subtotalEl) subtotalEl.textContent = data.total_formatted;
                if (grandtotalEl) grandtotalEl.textContent = data.total_formatted;
                if (mobileTotalEl) mobileTotalEl.textContent = data.total_formatted;
            }

            if (data.item_count !== undefined) {
                const badgeItems = document.getElementById('badge-total-items');
                const portionsEl = document.getElementById('summary-portions');
                const mobileCountEl = document.getElementById('mobile-summary-count');

                if (badgeItems) badgeItems.textContent = `${data.item_count} porsi`;
                if (portionsEl) portionsEl.textContent = `${data.item_count} porsi`;
                if (mobileCountEl) mobileCountEl.textContent = data.item_count;
            }
        }
    </script>
</body>
</html>
