<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - Kedai Bang Nana</title>
    <meta name="description" content="Lengkapi informasi pemesan untuk pesanan Anda di Kedai Bang Nana.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #0f172a; }

        /* Ambient Glows */
        .page-glow-1 {
            position: absolute; top: -10%; left: -5%;
            width: 500px; height: 500px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(236,72,153,.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .page-glow-2 {
            position: absolute; top: 40%; right: -10%;
            width: 450px; height: 450px; border-radius: 9999px;
            background: radial-gradient(circle, rgba(139,92,246,.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Glass Cards */
        .checkout-glass {
            background: rgba(30, 41, 59, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }
        .checkout-glass-highlight {
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(236, 72, 153, 0.25);
            box-shadow: 0 10px 30px -10px rgba(236, 72, 153, 0.15);
        }

        /* Radio Card Selection */
        .type-option-card {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }
        .type-option-card:hover {
            border-color: rgba(236, 72, 153, 0.3);
            background: rgba(255, 255, 255, 0.04);
        }
        .type-option-card.active {
            border-color: rgba(236, 72, 153, 0.6);
            background: rgba(236, 72, 153, 0.08);
            box-shadow: 0 0 20px -5px rgba(236, 72, 153, 0.2);
        }

        /* Custom Input Styling */
        .custom-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 0.85rem;
            padding: 0.85rem 1rem;
            color: #f8fafc;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            outline: none;
        }
        .custom-input.with-icon {
            padding-left: 3rem !important;
        }
        .custom-input:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
            background: rgba(15, 23, 42, 0.95);
        }

        /* Quick Table Badge */
        .table-pill {
            transition: all 0.15s ease;
            cursor: pointer;
            user-select: none;
        }
        .table-pill:hover {
            background: rgba(236, 72, 153, 0.2);
            border-color: rgba(236, 72, 153, 0.4);
            color: #f472b6;
        }
        .table-pill.active {
            background: linear-gradient(135deg, #ec4899, #db2777);
            border-color: #ec4899;
            color: #ffffff;
            font-weight: 700;
        }

        /* Mobile Bottom Checkout Bar */
        .mobile-submit-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 40;
            background: rgba(15, 23, 42, 0.95);
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
    <div class="page-glow-1"></div>
    <div class="page-glow-2"></div>

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
                <a href="{{ route('cart.view') }}" class="btn btn-ghost text-sm inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 border border-white/5">
                    <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Keranjang</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Progress Stepper -->
    <div class="border-b border-white/5 bg-slate-900/60 backdrop-blur-md">
        <div class="max-w-4xl mx-auto px-4 py-4 sm:py-5">
            <div class="flex items-center justify-between relative">
                <!-- Step 1: Keranjang (Completed) -->
                <a href="{{ route('cart.view') }}" class="flex items-center gap-2.5 sm:gap-3 z-10 group cursor-pointer">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center font-bold text-emerald-400 shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition">
                        <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold block">Selesai</span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-300 group-hover:text-white">Keranjang</span>
                    </div>
                </a>

                <!-- Connector Line 1-2 (Active Gradient) -->
                <div class="flex-1 mx-3 sm:mx-6 h-0.5 bg-gradient-to-r from-emerald-500/60 via-pink-500/60 to-pink-500 rounded"></div>

                <!-- Step 2: Checkout (Active Glow) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl gradient-primary flex items-center justify-center font-bold text-white shadow-lg shadow-pink-500/30 ring-2 ring-pink-500/40">
                        <i data-lucide="clipboard-pen" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-pink-400 font-bold block">Langkah 2</span>
                        <span class="text-xs sm:text-sm font-bold text-white">Data Pemesan</span>
                    </div>
                </div>

                <!-- Connector Line 2-3 (Inactive) -->
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

        <!-- Title Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                <i data-lucide="clipboard-pen" class="w-7 h-7 sm:w-8 sm:h-8 text-pink-500 flex-shrink-0"></i>
                <span>Konfirmasi Data Pemesan</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Lengkapi nama Anda dan pilih apakah ingin makan di kedai atau dibawa pulang.</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 backdrop-blur-md p-4 text-sm text-red-300 shadow-xl shadow-red-950/30">
                <div class="flex items-start gap-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-red-500/20 text-red-400 font-bold text-sm flex-shrink-0">⚠️</span>
                    <div>
                        <h3 class="font-bold text-red-200">Mohon periksa data formulir:</h3>
                        <ul class="mt-1 space-y-1 text-xs text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Left Column: Form (7-8 cols) -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">
                <form id="checkout-form" action="{{ route('order.checkout') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Card 1: Nama Pemesan -->
                    <div class="checkout-glass rounded-2xl p-6 sm:p-7 shadow-xl border border-white/10">
                        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-white/5">
                            <div class="w-8 h-8 rounded-lg bg-pink-500/10 text-pink-400 flex items-center justify-center font-bold">1</div>
                            <div>
                                <h2 class="text-base font-bold text-white">Identitas Pemesan</h2>
                                <p class="text-xs text-slate-400">Nama yang akan dipanggil saat pesanan siap</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="nama_pemesan">
                                Nama Lengkap / Panggilan <span class="text-pink-400">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input id="nama_pemesan" type="text" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
                                    class="custom-input with-icon" placeholder="Masukkan nama Anda (misal: Budi / Nana)" required autofocus>
                            </div>
                            @error('nama_pemesan')
                                <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">✕ {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Card 2: Tipe Pesanan & Meja -->
                    <div class="checkout-glass rounded-2xl p-6 sm:p-7 shadow-xl border border-white/10">
                        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-white/5">
                            <div class="w-8 h-8 rounded-lg bg-pink-500/10 text-pink-400 flex items-center justify-center font-bold">2</div>
                            <div>
                                <h2 class="text-base font-bold text-white">Tipe Layanan Pesanan</h2>
                                <p class="text-xs text-slate-400">Pilih apakah santap di tempat atau dibawa pulang</p>
                            </div>
                        </div>

                        <!-- Radio Cards Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            <!-- Dine In Card -->
                            @php
                                $selectedType = old('tipe_pesanan', 'Dine In');
                            @endphp
                            <label class="type-option-card rounded-2xl p-4 sm:p-5 border border-white/10 bg-slate-900/50 flex flex-col justify-between {{ $selectedType === 'Dine In' ? 'active' : '' }}" id="card-dine-in">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 text-pink-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="utensils" class="w-6 h-6"></i>
                                    </div>
                                    <input type="radio" name="tipe_pesanan" value="Dine In" id="radio-dine-in"
                                        {{ $selectedType === 'Dine In' ? 'checked' : '' }} class="h-5 w-5 accent-pink-500 mt-1 cursor-pointer">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-base">Makan di Tempat</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Menikmati hidangan hangat langsung di meja kedai kami.</p>
                                    <div class="mt-3">
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-pink-300 px-2 py-0.5 rounded-md bg-pink-500/10 border border-pink-500/20">
                                            <i data-lucide="armchair" class="w-3.5 h-3.5"></i>
                                            <span>Disediakan Meja</span>
                                        </span>
                                    </div>
                                </div>
                            </label>

                            <!-- Take Away Card -->
                            <label class="type-option-card rounded-2xl p-4 sm:p-5 border border-white/10 bg-slate-900/50 flex flex-col justify-between {{ $selectedType === 'Take Away' ? 'active' : '' }}" id="card-take-away">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                                    </div>
                                    <input type="radio" name="tipe_pesanan" value="Take Away" id="radio-take-away"
                                        {{ $selectedType === 'Take Away' ? 'checked' : '' }} class="h-5 w-5 accent-pink-500 mt-1 cursor-pointer">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-base">Bawa Pulang</h3>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Pesanan dibungkus higienis & rapi untuk dibawa pulang.</p>
                                    <div class="mt-3">
                                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-purple-300 px-2 py-0.5 rounded-md bg-purple-500/10 border border-purple-500/20">
                                            <i data-lucide="package" class="w-3.5 h-3.5"></i>
                                            <span>Dibungkus Rapi</span>
                                        </span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Nomor Meja Section (Conditional Display) -->
                        <div id="section-no-meja" class="pt-5 border-t border-white/5 transition-all duration-300">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" for="no_meja">
                                Nomor Meja Anda <span class="text-slate-400 font-normal">(Lihat stiker di atas meja)</span>
                            </label>
                            <div class="relative mb-3">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i data-lucide="hash" class="w-4 h-4"></i>
                                </div>
                                <input id="no_meja" type="text" name="no_meja" value="{{ old('no_meja') }}"
                                    class="custom-input with-icon" placeholder="Masukkan nomor meja (misal: 01 / VIP)">
                            </div>

                            <!-- Quick Select Pills -->
                            <div>
                                <p class="text-[11px] text-slate-400 mb-2">Pilih cepat nomor meja:</p>
                                <div class="flex flex-wrap gap-2" id="table-pills-container">
                                    @foreach(['1', '2', '3', '4', '5', '6', '7', '8', 'VIP-1', 'VIP-2'] as $tableNo)
                                        <button type="button" class="table-pill px-3 py-1.5 rounded-lg text-xs bg-slate-800/80 text-slate-300 border border-white/10" onclick="selectQuickTable('{{ $tableNo }}')">
                                            Meja {{ $tableNo }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            @error('no_meja')
                                <p class="mt-2 text-xs text-red-400">✕ {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Take Away Notice (Shown when Take Away selected) -->
                        <div id="section-take-away-notice" class="pt-4 border-t border-white/5 hidden">
                            <div class="rounded-xl bg-purple-500/10 border border-purple-500/20 p-3.5 flex items-center gap-3 text-xs text-purple-300">
                                <i data-lucide="shopping-bag" class="w-5 h-5 flex-shrink-0"></i>
                                <span>Nomor meja tidak diperlukan. Pesanan Anda akan dipanggil berdasarkan nama setelah selesai dibungkus.</span>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Actions for Desktop -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('cart.view') }}" class="btn btn-ghost w-full sm:w-auto px-6 py-3.5 rounded-xl text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/5 border border-white/10 flex items-center justify-center gap-2 transition">
                            <i data-lucide="arrow-left" class="w-4 h-4 text-pink-400"></i>
                            <span>Kembali ke Keranjang</span>
                        </a>

                        <button type="submit" class="btn btn-primary flex-1 w-full py-4 rounded-xl font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-pink-500/25 hover:shadow-pink-500/40 transform hover:-translate-y-0.5 transition duration-200">
                            <span>Lanjut ke Pilih Pembayaran</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </button>
                    </div>

                </form>
            </div>

            <!-- Right Column: Sticky Summary (4-5 cols) -->
            <div class="lg:col-span-5 xl:col-span-4 lg:sticky lg:top-24 space-y-4">

                <!-- Summary Card -->
                <div class="checkout-glass-highlight rounded-2xl p-6 relative overflow-hidden shadow-2xl">
                    <!-- Decorative Aura -->
                    <div class="absolute -top-12 -right-12 w-36 h-36 bg-pink-500/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-5">
                        <h2 class="text-base font-bold text-white flex items-center gap-2">
                            <i data-lucide="receipt" class="w-5 h-5 text-pink-400"></i>
                            <span>Ringkasan Pesanan</span>
                        </h2>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-pink-500/20 text-pink-300 border border-pink-500/30 font-semibold">
                            {{ count($cart) }} Menu
                        </span>
                    </div>

                    <!-- Items List -->
                    <div class="max-h-60 overflow-y-auto pr-1 space-y-3 pb-4 mb-4 border-b border-white/10">
                        @php $grandTotal = 0; $totalPortions = 0; @endphp
                        @foreach ($cart as $menuId => $item)
                            @php
                                $subtotal = $item['harga'] * $item['quantity'];
                                $grandTotal += $subtotal;
                                $totalPortions += $item['quantity'];
                            @endphp
                            <div class="flex items-start justify-between gap-3 text-sm">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-1.5 py-0.5 rounded bg-white/10 text-[11px] font-bold text-pink-300">
                                            {{ $item['quantity'] }}x
                                        </span>
                                        <span class="font-medium text-slate-200 truncate">{{ $item['nama_menu'] }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-400 pl-7">@ Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                </div>
                                <span class="font-semibold text-white flex-shrink-0 text-sm">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="space-y-3 border-b border-white/10 pb-5 text-sm">
                        <div class="flex items-center justify-between text-slate-300">
                            <span>Total Porsi</span>
                            <span class="font-semibold text-white">{{ $totalPortions }} porsi</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span>Subtotal Menu</span>
                            <span class="font-semibold text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-1.5">
                                <span>Pajak & Layanan</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-medium">Termasuk</span>
                            </span>
                            <span class="font-semibold text-emerald-400">Gratis (Rp 0)</span>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="py-5 border-b border-white/10">
                        <div class="flex items-baseline justify-between">
                            <div>
                                <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block">Total Bayar</span>
                                <span class="text-[11px] text-slate-500">Jumlah final</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-300 tracking-tight">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Process Info Card -->
                    <div class="mt-5 rounded-xl bg-pink-500/10 border border-pink-500/20 p-3.5 flex items-start gap-3">
                        <span class="text-lg">⚡</span>
                        <div class="text-xs">
                            <p class="font-bold text-pink-300">Pesanan Diproses Otomatis</p>
                            <p class="text-slate-400 mt-0.5">Setelah memilih pembayaran, dapur kami akan langsung mempersiapkan pesanan Anda.</p>
                        </div>
                    </div>

                    <!-- Guarantees -->
                    <div class="mt-5 pt-3 border-t border-white/5 space-y-2 text-center text-xs text-slate-400">
                        <div class="flex items-center justify-center gap-2 text-slate-400">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Sistem Kasir Kedai Bang Nana Resmi</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Sticky Mobile Bottom Bar -->
        <div class="mobile-submit-bar sm:hidden flex items-center justify-between gap-3">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Total Pesanan</span>
                <span class="text-lg font-black text-pink-400">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </span>
            </div>
            <button type="button" onclick="document.getElementById('checkout-form').requestSubmit()" class="btn btn-primary px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-lg shadow-pink-500/20">
                <span>Lanjut Bayar</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>

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

    <!-- Interactive Script -->
    <script>
        if (window.lucide) {
            lucide.createIcons();
        }

        const radioDineIn = document.getElementById('radio-dine-in');
        const radioTakeAway = document.getElementById('radio-take-away');
        const cardDineIn = document.getElementById('card-dine-in');
        const cardTakeAway = document.getElementById('card-take-away');
        const sectionNoMeja = document.getElementById('section-no-meja');
        const sectionTakeAwayNotice = document.getElementById('section-take-away-notice');
        const inputNoMeja = document.getElementById('no_meja');

        function updateTypeSelection() {
            if (radioDineIn.checked) {
                cardDineIn.classList.add('active');
                cardTakeAway.classList.remove('active');
                sectionNoMeja.classList.remove('hidden');
                sectionTakeAwayNotice.classList.add('hidden');
            } else {
                cardTakeAway.classList.add('active');
                cardDineIn.classList.remove('active');
                sectionNoMeja.classList.add('hidden');
                sectionTakeAwayNotice.classList.remove('hidden');
            }
        }

        radioDineIn.addEventListener('change', updateTypeSelection);
        radioTakeAway.addEventListener('change', updateTypeSelection);

        // Initial setup
        updateTypeSelection();

        // Quick select table pill
        function selectQuickTable(tableNo) {
            if (inputNoMeja) {
                inputNoMeja.value = tableNo;
                inputNoMeja.focus();

                // Highlight active pill
                document.querySelectorAll('.table-pill').forEach(btn => {
                    if (btn.textContent.trim() === `Meja ${tableNo}`) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }
        }

        // Sync pill if user manually types
        inputNoMeja?.addEventListener('input', function() {
            const val = this.value.trim();
            document.querySelectorAll('.table-pill').forEach(btn => {
                if (btn.textContent.trim() === `Meja ${val}`) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
