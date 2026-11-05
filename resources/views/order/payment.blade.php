<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pembayaran - Kedai Bang Nana</title>
    <meta name="description" content="Pilih metode pembayaran aman untuk pesanan Anda di Kedai Bang Nana.">
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
        .pay-glass {
            background: rgba(30, 41, 59, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(148, 163, 184, 0.12);
        }
        .pay-glass-highlight {
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(236, 72, 153, 0.25);
            box-shadow: 0 10px 30px -10px rgba(236, 72, 153, 0.15);
        }

        /* Payment Option Cards */
        .pay-method-card {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .pay-method-card:hover {
            transform: translateY(-2px);
        }
        .pay-card-cash:hover {
            border-color: rgba(16, 185, 129, 0.4) !important;
            box-shadow: 0 12px 30px -5px rgba(16, 185, 129, 0.15);
        }
        .pay-card-online:hover {
            border-color: rgba(59, 130, 246, 0.4) !important;
            box-shadow: 0 12px 30px -5px rgba(59, 130, 246, 0.15);
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
                <a href="{{ route('menu.public') }}" class="btn btn-ghost text-sm inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 border border-white/5">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Menu Utama</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Progress Stepper -->
    <div class="border-b border-white/5 bg-slate-900/60 backdrop-blur-md">
        <div class="max-w-4xl mx-auto px-4 py-4 sm:py-5">
            <div class="flex items-center justify-between relative">
                <!-- Step 1: Keranjang (Completed) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10 opacity-75">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center font-bold text-emerald-400 shadow-lg shadow-emerald-500/20">
                        <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold block">Selesai</span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-300">Keranjang</span>
                    </div>
                </div>

                <!-- Connector Line 1-2 (Active Gradient) -->
                <div class="flex-1 mx-3 sm:mx-6 h-0.5 bg-gradient-to-r from-emerald-500/60 to-emerald-500/60 rounded"></div>

                <!-- Step 2: Checkout (Completed) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10 opacity-75">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center font-bold text-emerald-400 shadow-lg shadow-emerald-500/20">
                        <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div class="hidden sm:block">
                        <span class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold block">Selesai</span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-300">Data Pemesan</span>
                    </div>
                </div>

                <!-- Connector Line 2-3 (Active Gradient to Pink) -->
                <div class="flex-1 mx-3 sm:mx-6 h-0.5 bg-gradient-to-r from-emerald-500/60 via-pink-500/60 to-pink-500 rounded"></div>

                <!-- Step 3: Payment (Active Glow) -->
                <div class="flex items-center gap-2.5 sm:gap-3 z-10">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl gradient-primary flex items-center justify-center font-bold text-white shadow-lg shadow-pink-500/30 ring-2 ring-pink-500/40">
                        <i data-lucide="credit-card" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider text-pink-400 font-bold block">Langkah 3</span>
                        <span class="text-xs sm:text-sm font-bold text-white">Pembayaran</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 pb-20">

        <!-- Title & Order Meta Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight flex items-center gap-3">
                        <i data-lucide="wallet-cards" class="w-7 h-7 sm:w-8 sm:h-8 text-pink-500 flex-shrink-0"></i>
                        <span>Pilih Metode Pembayaran</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1">Pilih metode pembayaran yang paling nyaman untuk menyelesaikan pesanan Anda.</p>
                </div>

                <!-- Order Tag Pill -->
                <div class="flex items-center gap-2.5 p-2 px-3.5 rounded-xl bg-slate-800/80 border border-white/10 w-fit">
                    <span class="text-xs text-slate-400">No. Order:</span>
                    <span class="text-xs font-mono font-bold text-pink-400" id="order-no">{{ $order->no_order }}</span>
                    <button type="button" onclick="copyOrderNo()" class="text-slate-400 hover:text-white p-1 transition rounded-lg hover:bg-white/10 flex items-center justify-center" title="Salin No. Order">
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Left Column: Payment Options (7-8 cols) -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-5">

                <!-- Alert Information Box -->
                <div class="rounded-2xl bg-slate-900/60 border border-white/10 p-4.5 flex items-start gap-3.5 backdrop-blur-md">
                    <div class="w-8 h-8 rounded-lg bg-pink-500/20 text-pink-400 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                    </div>
                    <div class="text-xs leading-relaxed text-slate-300">
                        <strong class="text-white block font-semibold mb-0.5">Pesanan Anda telah dicatat dalam antrean!</strong>
                        Silakan pilih untuk membayar secara online (QRIS/E-Wallet/Transfer) tanpa perlu antre, atau bayar langsung dengan uang tunai di meja kasir.
                    </div>
                </div>

                <!-- Option 1: Bayar Tunai di Kasir -->
                <div class="pay-glass pay-method-card pay-card-cash rounded-2xl p-6 sm:p-7 border border-white/10 shadow-xl group">
                    <form action="{{ route('pembayaran.cash', $order->id_order) }}" method="POST">
                        @csrf
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                            <div class="flex items-start gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-500/10">
                                    <i data-lucide="banknote" class="w-7 h-7"></i>
                                </div>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2.5 flex-wrap">
                                        <h2 class="text-lg font-bold text-white group-hover:text-emerald-300 transition">Bayar Tunai di Kasir</h2>
                                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                                            Tanpa Biaya Admin
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                        Bayar langsung dengan uang tunai (cash) ke meja kasir. Cukup sebutkan nama atau tunjukkan nomor pesanan Anda ke petugas kasir.
                                    </p>
                                    <div class="flex items-center gap-2 pt-2 text-xs text-slate-400">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400"></i>
                                        <span>Proses instan di kedai</span>
                                        <span class="text-slate-600">•</span>
                                        <i data-lucide="receipt" class="w-4 h-4 text-emerald-400"></i>
                                        <span>Dapat cetak struk fisik</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-sm bg-emerald-500 hover:bg-emerald-400 text-slate-950 flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 transform hover:-translate-y-0.5 transition duration-200 flex-shrink-0">
                                <span>Pilih Bayar Tunai</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Option 2: Pembayaran Digital / Online (Midtrans QRIS) -->
                <div class="pay-glass pay-method-card pay-card-online rounded-2xl p-6 sm:p-7 border border-white/10 shadow-xl group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-blue-500/20 border border-blue-500/30 text-blue-400 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/10">
                                <i data-lucide="qr-code" class="w-7 h-7"></i>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h2 class="text-lg font-bold text-white group-hover:text-blue-300 transition">QRIS & Pembayaran Online</h2>
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-blue-500/15 text-blue-400 border border-blue-500/30">
                                        Otomatis & Bebas Antre
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                                    Bayar praktis melalui QRIS, GoPay, OVO, ShopeePay, Transfer Bank (BCA, Mandiri, BNI, BRI), atau Kartu Kredit/Debit secara instan.
                                </p>

                                <!-- Supported Channel Badges -->
                                <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/10">QRIS</span>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/10">GoPay</span>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/10">OVO</span>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/10">ShopeePay</span>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/10">BCA VA</span>
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-white/5 text-slate-300 border border-white/10">Kartu Kredit</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('pembayaran.snap', $order->id_order) }}" class="btn w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white flex items-center justify-center gap-2 shadow-lg shadow-blue-500/25 transform hover:-translate-y-0.5 transition duration-200 flex-shrink-0">
                            <span>Bayar Online Sekarang</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                <!-- Detail Pesanan Info Card -->
                <div class="pay-glass rounded-2xl p-5 border border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-slate-300 flex items-center justify-center">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Pemesan</p>
                            <p class="font-bold text-white text-sm">{{ $order->nama_pelanggan }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-pink-400 flex items-center justify-center">
                            @if(str_contains(strtolower($order->tipe_pesanan), 'dine'))
                                <i data-lucide="utensils" class="w-5 h-5"></i>
                            @else
                                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Layanan</p>
                            <p class="font-bold text-white text-sm">
                                {{ $order->tipe_pesanan }}
                                @if($order->no_meja)
                                    <span class="text-pink-400 font-semibold">(Meja {{ $order->no_meja }})</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Status</p>
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-300">
                                Menunggu Pembayaran
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Sticky Summary (4-5 cols) -->
            <div class="lg:col-span-5 xl:col-span-4 lg:sticky lg:top-24 space-y-4">

                <!-- Summary Card -->
                <div class="pay-glass-highlight rounded-2xl p-6 relative overflow-hidden shadow-2xl">
                    <!-- Decorative Aura -->
                    <div class="absolute -top-12 -right-12 w-36 h-36 bg-pink-500/20 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-5">
                        <h2 class="text-base font-bold text-white flex items-center gap-2">
                            <i data-lucide="receipt" class="w-5 h-5 text-pink-400"></i>
                            <span>Rincian Tagihan</span>
                        </h2>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-pink-500/20 text-pink-300 border border-pink-500/30 font-semibold">
                            {{ count($orderItems) }} Menu
                        </span>
                    </div>

                    <!-- Ordered Items List -->
                    <div class="max-h-60 overflow-y-auto pr-1 space-y-3 pb-4 mb-4 border-b border-white/10">
                        @php $totalPortions = 0; @endphp
                        @foreach ($orderItems as $item)
                            @php $totalPortions += $item->jumlah; @endphp
                            <div class="flex items-start justify-between gap-3 text-sm">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-1.5 py-0.5 rounded bg-white/10 text-[11px] font-bold text-pink-300">
                                            {{ $item->jumlah }}x
                                        </span>
                                        <span class="font-medium text-slate-200 truncate">{{ $item->menu->nama_menu }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-400 pl-7">@ Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                </div>
                                <span class="font-semibold text-white flex-shrink-0 text-sm">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Breakdown -->
                    <div class="space-y-3 border-b border-white/10 pb-5 text-sm">
                        <div class="flex items-center justify-between text-slate-300">
                            <span>Total Porsi</span>
                            <span class="font-semibold text-white">{{ $totalPortions }} porsi</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span>Subtotal Menu</span>
                            <span class="font-semibold text-white">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-300">
                            <span class="flex items-center gap-1.5">
                                <span>Biaya Layanan & Pajak</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-medium">Termasuk</span>
                            </span>
                            <span class="font-semibold text-emerald-400">Rp 0</span>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="py-5 border-b border-white/10">
                        <div class="flex items-baseline justify-between">
                            <div>
                                <span class="text-xs uppercase tracking-wider text-slate-400 font-bold block">Total Yang Harus Dibayar</span>
                                <span class="text-[11px] text-slate-500">Harga final pesanan</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-rose-300 tracking-tight">
                                    Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Guarantees -->
                    <div class="mt-5 space-y-2 text-center text-xs text-slate-400">
                        <div class="flex items-center justify-center gap-2 text-slate-400">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            <span>Transaksi Terverifikasi Sistem POS</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Nota otomatis tercetak saat pembayaran dikonfirmasi kasir atau sistem Midtrans.</p>
                    </div>

                </div>

            </div>

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

    <!-- Scripts -->
    <script>
        // Init Lucide Icons
        if (window.lucide) {
            lucide.createIcons();
        }

        // Script Copy Order Number
        function copyOrderNo() {
            const orderNo = document.getElementById('order-no')?.textContent;
            if (orderNo) {
                navigator.clipboard.writeText(orderNo).then(() => {
                    alert('Nomor pesanan disalin: ' + orderNo);
                }).catch(() => {});
            }
        }
    </script>
</body>
</html>
