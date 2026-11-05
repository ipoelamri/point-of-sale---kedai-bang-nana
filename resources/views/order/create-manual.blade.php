@extends('layouts.app')

@section('title', 'Pesan Manual (POS Kasir)')

@section('content')
<div x-data="posSystem()" class="space-y-5">

    <!-- Header Section -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('kasir.pesanan') }}" class="hover:text-pink-400 transition">Pesanan</a>
                <span>/</span>
                <span class="text-slate-200">Pesan Manual (POS)</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white flex items-center gap-2.5">
                <i data-lucide="calculator" class="w-7 h-7 text-pink-500"></i>
                <span>Pesan Manual (Kasir POS)</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">Input transaksi pesanan langsung untuk pelanggan di meja kasir</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('kasir.pesanan') }}" class="btn btn-ghost px-3.5 py-2 text-xs text-slate-300 hover:text-white border border-white/10 rounded-xl inline-flex items-center gap-1.5 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
            <div class="flex items-center gap-2 rounded-xl bg-pink-500/10 border border-pink-500/20 px-3 py-2 text-xs text-pink-300">
                <i data-lucide="user-check" class="w-4 h-4"></i>
                <span>Kasir: <strong>{{ Auth::user()->username ?? 'Kasir' }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
            <div class="flex items-center gap-2 font-bold mb-1">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span>Periksa kembali input formulir:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Grid: Left Catalog (7 cols) & Right POS Checkout (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- ==============================================
             LEFT COLUMN: MENU CATALOG
             ============================================== -->
        <div class="lg:col-span-7 xl:col-span-7 space-y-4">

            <!-- Search Bar & Category Filters -->
            <div class="glass-card rounded-2xl p-4 space-y-3 border border-white/10 shadow-lg">
                <!-- Search input -->
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Cari nama menu makanan atau minuman..."
                           class="w-full bg-slate-900/80 border border-white/10 rounded-xl pl-10 pr-9 py-2.5 text-xs sm:text-sm text-white placeholder-slate-500 focus:outline-none focus:border-pink-500 transition shadow-inner">
                    <button type="button"
                            x-show="searchQuery"
                            @click="searchQuery = ''"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white p-1">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                </div>

                <!-- Category Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                    <button type="button"
                            @click="selectedCategory = 'all'"
                            :class="selectedCategory === 'all' 
                                    ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg shadow-pink-500/25 border-pink-400/40' 
                                    : 'bg-slate-800/80 text-slate-300 hover:text-white border-white/5'"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap border transition">
                        Semua Menu (<span x-text="menuList.length"></span>)
                    </button>
                    @foreach ($kategoris as $kat)
                        <button type="button"
                                @click="selectedCategory = '{{ $kat->nama_kategori }}'"
                                :class="selectedCategory === '{{ $kat->nama_kategori }}' 
                                        ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg shadow-pink-500/25 border-pink-400/40' 
                                        : 'bg-slate-800/80 text-slate-300 hover:text-white border-white/5'"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap border transition">
                            {{ $kat->nama_kategori }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Menu Cards Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5 max-h-[calc(100vh-250px)] overflow-y-auto pr-1">
                <template x-for="menu in filteredMenus" :key="menu.id_menu">
                    <div @click="addToCart(menu)"
                         class="glass-card rounded-2xl p-3 cursor-pointer relative group transition-all duration-200 hover:-translate-y-1 hover:border-pink-500/40 hover:shadow-xl hover:shadow-pink-500/10 flex flex-col justify-between border border-white/5">

                        <!-- Selected Badge in Cart -->
                        <div x-show="getItemQty(menu.id_menu) > 0"
                             class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs font-black flex items-center justify-center shadow-lg shadow-pink-500/50 border border-white/30 animate-pulse z-10"
                             x-text="getItemQty(menu.id_menu)">
                        </div>

                        <div>
                            <!-- Image Thumbnail -->
                            <div class="aspect-square w-full rounded-xl overflow-hidden bg-slate-900/80 mb-2.5 relative border border-white/5">
                                <template x-if="menu.foto_url">
                                    <img :src="menu.foto_url"
                                         :alt="menu.nama_menu"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                         onerror="this.src='https://placehold.co/300x300/1e293b/475569?text=Menu'">
                                </template>
                                <template x-if="!menu.foto_url">
                                    <div class="w-full h-full flex items-center justify-center text-slate-500 bg-slate-800">
                                        <i data-lucide="utensils" class="w-7 h-7"></i>
                                    </div>
                                </template>

                                <!-- Category Badge -->
                                <span class="absolute bottom-1.5 left-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-md bg-slate-950/85 text-slate-300 backdrop-blur-sm border border-white/5"
                                      x-text="menu.kategori_nama"></span>
                            </div>

                            <!-- Info -->
                            <h3 class="font-bold text-white text-xs sm:text-sm line-clamp-1 group-hover:text-pink-400 transition" x-text="menu.nama_menu"></h3>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs font-black text-amber-400" x-text="formatRupiah(menu.harga)"></span>
                                <span class="text-[10px] text-slate-500" x-text="'Stok: ' + menu.stok"></span>
                            </div>
                        </div>

                        <!-- Add Indicator Button -->
                        <button type="button"
                                class="mt-2.5 w-full py-1.5 rounded-lg bg-white/5 group-hover:bg-gradient-to-r group-hover:from-pink-500/20 group-hover:to-rose-500/20 group-hover:text-pink-300 group-hover:border-pink-500/30 text-slate-300 text-xs font-semibold flex items-center justify-center gap-1.5 border border-white/5 transition">
                            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="filteredMenus.length === 0" class="col-span-full py-12 text-center text-slate-500 glass-card rounded-2xl border border-white/10">
                    <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-2 text-slate-600"></i>
                    <p class="text-sm font-semibold text-slate-400">Tidak ada menu yang sesuai kriteria pencarian</p>
                    <p class="text-xs text-slate-500 mt-0.5">Coba gunakan kata kunci lain atau pilih kategori Semua Menu</p>
                </div>
            </div>

        </div>

        <!-- ==============================================
             RIGHT COLUMN: POS BILLING & CHECKOUT
             ============================================== -->
        <div class="lg:col-span-5 xl:col-span-5 lg:sticky lg:top-4">

            <form action="{{ route('kasir.pesanan.manual.store') }}" method="POST" id="form-pos-manual" class="space-y-4">
                @csrf

                <!-- Main POS Card -->
                <div class="glass-card rounded-3xl p-5 border border-white/10 shadow-2xl space-y-4">

                    <!-- Header Cart -->
                    <div class="flex items-center justify-between pb-3 border-b border-white/10">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-pink-500/20 border border-pink-500/30 flex items-center justify-center text-pink-400">
                                <i data-lucide="receipt" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h2 class="font-extrabold text-white text-sm sm:text-base">Tagihan Pesanan</h2>
                                <p class="text-[11px] text-slate-400">Rincian checkout kasir</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-xs px-2.5 py-1 rounded-full bg-pink-500/20 text-pink-300 border border-pink-500/30 font-bold"
                                  x-text="cart.length + ' Menu Dipilih'"></span>
                            <button type="button"
                                    x-show="cart.length > 0"
                                    @click="clearCart()"
                                    class="text-xs text-red-400 hover:text-red-300 font-semibold px-2 py-1 rounded-lg hover:bg-red-500/10 transition">
                                Reset
                            </button>
                        </div>
                    </div>

                    <!-- Customer & Service Section -->
                    <div class="space-y-3">
                        <!-- Nama Pelanggan -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">
                                Nama Pelanggan <span class="text-pink-400">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </span>
                                <input type="text"
                                       name="nama_pelanggan"
                                       required
                                       placeholder="Contoh: Bpk. Budi / Pelanggan #1"
                                       class="w-full bg-slate-900/80 border border-white/10 rounded-xl pl-9 pr-3 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-pink-500 shadow-inner transition">
                            </div>
                        </div>

                        <!-- Tipe Layanan (Segmented Buttons) -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Tipe Pesanan</label>
                            <div class="grid grid-cols-2 gap-2 bg-slate-900/90 p-1 rounded-xl border border-white/10">
                                <button type="button"
                                        @click="tipePesanan = 'Dine In'"
                                        :class="tipePesanan === 'Dine In' 
                                                ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md' 
                                                : 'text-slate-400 hover:text-white'"
                                        class="py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition duration-200">
                                    <i data-lucide="utensils" class="w-3.5 h-3.5"></i>
                                    <span>Makan di Tempat</span>
                                </button>
                                <button type="button"
                                        @click="tipePesanan = 'Take Away'"
                                        :class="tipePesanan === 'Take Away' 
                                                ? 'bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-md' 
                                                : 'text-slate-400 hover:text-white'"
                                        class="py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-1.5 transition duration-200">
                                    <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
                                    <span>Bawa Pulang</span>
                                </button>
                            </div>
                            <input type="hidden" name="tipe_pesanan" :value="tipePesanan">
                        </div>

                        <!-- Nomor Meja (Shown only for Dine In) -->
                        <div x-show="tipePesanan === 'Dine In'" x-transition class="p-3 rounded-xl bg-slate-900/60 border border-white/5 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-semibold text-slate-300">Nomor Meja</label>
                                <span class="text-[11px] font-bold text-pink-400" x-show="noMeja" x-text="'Terpilih: Meja ' + noMeja"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text"
                                       name="no_meja"
                                       x-model="noMeja"
                                       placeholder="Ketik meja (cth: 01, VIP)"
                                       class="flex-1 bg-slate-950/80 border border-white/10 rounded-xl px-3 py-1.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-pink-500">
                                <button type="button"
                                        x-show="noMeja"
                                        @click="noMeja = ''"
                                        class="px-2 py-1.5 rounded-lg text-[11px] bg-slate-800 text-slate-400 hover:text-white">
                                    Hapus
                                </button>
                            </div>
                            <!-- Quick Table Chips -->
                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                <template x-for="table in ['1', '2', '3', '4', '5', '6', '7', '8', 'VIP-1']" :key="table">
                                    <button type="button"
                                            @click="noMeja = table"
                                            :class="noMeja === table ? 'bg-pink-500 text-white shadow' : 'bg-slate-800/90 text-slate-300 hover:text-white border border-white/5'"
                                            class="px-2 py-1 rounded-md text-[11px] font-semibold transition active:scale-95"
                                            x-text="'M-' + table">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Item List (WITH FOOD PHOTOS) -->
                    <div class="border-t border-b border-white/10 py-3 space-y-2.5 max-h-60 sm:max-h-64 overflow-y-auto pr-1">
                        <!-- Empty Cart State -->
                        <template x-if="cart.length === 0">
                            <div class="py-8 text-center text-slate-500">
                                <i data-lucide="shopping-cart" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                <p class="text-xs font-semibold text-slate-400">Keranjang masih kosong</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Pilih menu di sebelah kiri untuk menambah pesanan</p>
                            </div>
                        </template>

                        <!-- Items in Cart -->
                        <template x-for="(item, index) in cart" :key="item.menu_id">
                            <div class="p-2.5 rounded-2xl bg-slate-900/80 border border-white/5 space-y-2 hover:border-white/15 transition shadow-sm">
                                <div class="flex items-center gap-3">
                                    <!-- Food Thumbnail Image -->
                                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-800 flex-shrink-0 border border-white/10 relative shadow">
                                        <template x-if="item.foto_url">
                                            <img :src="item.foto_url"
                                                 :alt="item.nama_menu"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.src='https://placehold.co/100x100/1e293b/475569?text=Menu'">
                                        </template>
                                        <template x-if="!item.foto_url">
                                            <div class="w-full h-full flex items-center justify-center text-slate-500 bg-slate-800">
                                                <i data-lucide="utensils" class="w-5 h-5"></i>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Details -->
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs sm:text-sm font-bold text-white truncate" x-text="item.nama_menu"></p>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="text-[11px] text-slate-400" x-text="formatRupiah(item.harga) + ' / porsi'"></span>
                                        </div>
                                        <div class="text-xs font-black text-amber-400 mt-1" x-text="formatRupiah(item.harga * item.jumlah)"></div>
                                    </div>

                                    <!-- Stepper & Delete -->
                                    <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                        <button type="button"
                                                @click="removeItem(item.menu_id)"
                                                class="text-slate-500 hover:text-red-400 p-1 rounded-md hover:bg-red-500/10 transition"
                                                title="Hapus menu">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>

                                        <div class="flex items-center gap-1 bg-slate-950/80 rounded-xl p-0.5 border border-white/10 shadow-inner">
                                            <button type="button"
                                                    @click="decreaseQty(item.menu_id)"
                                                    class="w-6 h-6 rounded-lg bg-slate-800 hover:bg-white/10 text-slate-200 flex items-center justify-center text-xs font-bold transition">
                                                −
                                            </button>
                                            <span class="w-5 text-center text-xs font-black text-white" x-text="item.jumlah"></span>
                                            <button type="button"
                                                    @click="increaseQty(item.menu_id)"
                                                    class="w-6 h-6 rounded-lg bg-slate-800 hover:bg-white/10 text-slate-200 flex items-center justify-center text-xs font-bold transition">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Note input -->
                                <div class="relative">
                                    <input type="text"
                                           :name="'items[' + index + '][catatan]'"
                                           x-model="item.catatan"
                                           placeholder="Catatan khusus (misal: pedas, tanpa es)..."
                                           class="w-full bg-slate-950/70 border border-white/5 rounded-xl px-2.5 py-1 text-[11px] text-slate-300 placeholder-slate-600 focus:outline-none focus:border-pink-500/50">
                                </div>

                                <!-- Hidden Inputs for Submission -->
                                <input type="hidden" :name="'items[' + index + '][menu_id]'" :value="item.menu_id">
                                <input type="hidden" :name="'items[' + index + '][jumlah]'" :value="item.jumlah">
                            </div>
                        </template>
                    </div>

                    <!-- Total Tagihan Display -->
                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-slate-900/90 to-slate-900/50 border border-white/10 flex items-center justify-between shadow-inner">
                        <div>
                            <span class="text-xs uppercase font-bold tracking-wider text-slate-400">Total Tagihan</span>
                            <p class="text-[11px] text-slate-500" x-text="cart.reduce((sum, item) => sum + item.jumlah, 0) + ' item porsi'"></p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-rose-300 to-amber-300 font-mono tracking-tight"
                                  x-text="formatRupiah(totalBayar)"></span>
                        </div>
                    </div>

                    <!-- STATUS PEMBAYARAN (BESAR & TIDAK PADAT) -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                            Pilih Status Pembayaran
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <!-- LUNAS (TUNAI) -->
                            <label class="cursor-pointer relative rounded-2xl p-4 border-2 transition-all duration-200 flex flex-col items-center text-center gap-2 select-none"
                                   :class="statusPembayaran === 'lunas' 
                                           ? 'bg-emerald-500/20 border-emerald-500 text-white shadow-xl shadow-emerald-500/20 ring-2 ring-emerald-500/20 scale-[1.02]' 
                                           : 'bg-slate-900/70 border-white/10 text-slate-400 hover:border-white/20 hover:text-slate-200'">
                                <input type="radio" name="status_pembayaran" value="lunas" x-model="statusPembayaran" class="hidden">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition"
                                     :class="statusPembayaran === 'lunas' ? 'bg-emerald-500 text-slate-950 font-bold shadow-lg shadow-emerald-500/40' : 'bg-slate-800 text-slate-400'">
                                    <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="font-black text-sm tracking-tight" :class="statusPembayaran === 'lunas' ? 'text-emerald-300' : 'text-slate-200'">Lunas (Tunai)</p>
                                    <p class="text-[11px] opacity-75 mt-0.5">Bayar Sekarang</p>
                                </div>
                                <div x-show="statusPembayaran === 'lunas'" class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-emerald-500 text-slate-950 rounded-full flex items-center justify-center text-xs font-black shadow">
                                    ✓
                                </div>
                            </label>

                            <!-- BAYAR NANTI -->
                            <label class="cursor-pointer relative rounded-2xl p-4 border-2 transition-all duration-200 flex flex-col items-center text-center gap-2 select-none"
                                   :class="statusPembayaran === 'pending' 
                                           ? 'bg-amber-500/20 border-amber-500 text-white shadow-xl shadow-amber-500/20 ring-2 ring-amber-500/20 scale-[1.02]' 
                                           : 'bg-slate-900/70 border-white/10 text-slate-400 hover:border-white/20 hover:text-slate-200'">
                                <input type="radio" name="status_pembayaran" value="pending" x-model="statusPembayaran" class="hidden">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition"
                                     :class="statusPembayaran === 'pending' ? 'bg-amber-500 text-slate-950 font-bold shadow-lg shadow-amber-500/40' : 'bg-slate-800 text-slate-400'">
                                    <i data-lucide="clock" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="font-black text-sm tracking-tight" :class="statusPembayaran === 'pending' ? 'text-amber-300' : 'text-slate-200'">Bayar Nanti</p>
                                    <p class="text-[11px] opacity-75 mt-0.5">Open Bill / Meja</p>
                                </div>
                                <div x-show="statusPembayaran === 'pending'" class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-amber-500 text-slate-950 rounded-full flex items-center justify-center text-xs font-black shadow">
                                    ✓
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Cash Change Calculator (When Lunas selected) -->
                    <div x-show="statusPembayaran === 'lunas'" x-transition class="p-4 rounded-2xl bg-slate-900/80 border border-white/10 space-y-3 shadow-inner">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Uang Tunai Diterima (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">Rp</span>
                                <input type="number"
                                       name="uang_diterima"
                                       x-model.number="uangDiterima"
                                       placeholder="0"
                                       class="w-full bg-slate-950 border border-white/10 rounded-xl pl-11 pr-4 py-2.5 text-right text-base sm:text-lg font-black text-emerald-400 focus:outline-none focus:border-emerald-500 shadow-inner">
                            </div>
                        </div>

                        <!-- Quick Cash Chips -->
                        <div>
                            <span class="block text-[11px] font-medium text-slate-400 mb-1.5">Pilihan Cepat:</span>
                            <div class="grid grid-cols-5 gap-1.5">
                                <button type="button"
                                        @click="uangDiterima = totalBayar"
                                        class="py-1.5 px-1 rounded-lg text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/30 text-center transition">
                                    Pas
                                </button>
                                <button type="button"
                                        @click="uangDiterima = (uangDiterima || 0) + 10000"
                                        class="py-1.5 px-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-200 hover:bg-slate-700 text-center transition">
                                    +10k
                                </button>
                                <button type="button"
                                        @click="uangDiterima = (uangDiterima || 0) + 20000"
                                        class="py-1.5 px-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-200 hover:bg-slate-700 text-center transition">
                                    +20k
                                </button>
                                <button type="button"
                                        @click="uangDiterima = (uangDiterima || 0) + 50000"
                                        class="py-1.5 px-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-200 hover:bg-slate-700 text-center transition">
                                    +50k
                                </button>
                                <button type="button"
                                        @click="uangDiterima = (uangDiterima || 0) + 100000"
                                        class="py-1.5 px-1 rounded-lg text-xs font-semibold bg-slate-800 text-slate-200 hover:bg-slate-700 text-center transition">
                                    +100k
                                </button>
                            </div>
                        </div>

                        <!-- Kembalian Banner -->
                        <div class="p-3 rounded-xl border flex items-center justify-between"
                             :class="kembalian >= 0 ? 'bg-emerald-950/40 border-emerald-500/30' : 'bg-red-950/40 border-red-500/30'">
                            <div class="flex items-center gap-2">
                                <i :data-lucide="kembalian >= 0 ? 'coins' : 'alert-circle'"
                                   class="w-4 h-4"
                                   :class="kembalian >= 0 ? 'text-emerald-400' : 'text-red-400'"></i>
                                <span class="text-xs font-bold"
                                      :class="kembalian >= 0 ? 'text-emerald-300' : 'text-red-300'"
                                      x-text="kembalian >= 0 ? 'Kembalian:' : 'Uang Kurang:'"></span>
                            </div>
                            <span class="text-base sm:text-lg font-black font-mono"
                                  :class="kembalian >= 0 ? 'text-emerald-400' : 'text-red-400'"
                                  x-text="formatRupiah(Math.abs(kembalian))"></span>
                        </div>
                    </div>

                    <!-- Hidden cetak struk field -->
                    <input type="hidden" name="cetak_struk" id="cetak_struk" value="0">

                    <!-- Actions Buttons -->
                    <div class="space-y-2.5 pt-2">
                        <!-- Simpan & Cetak Struk (WARNA LOGO: Signature Pink Brand) -->
                        <button type="submit"
                                :disabled="cart.length === 0"
                                @click="document.getElementById('cetak_struk').value = '1'"
                                class="btn w-full py-3.5 px-4 rounded-2xl font-black text-sm tracking-wide bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-400 hover:via-rose-400 hover:to-pink-500 text-white flex items-center justify-center gap-2.5 shadow-xl shadow-pink-500/30 border border-pink-400/40 disabled:opacity-40 disabled:cursor-not-allowed transform hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                            <i data-lucide="printer" class="w-5 h-5"></i>
                            <span>SIMPAN & CETAK STRUK</span>
                        </button>

                        <!-- Simpan Saja (Tanpa Struk) -->
                        <button type="submit"
                                :disabled="cart.length === 0"
                                @click="document.getElementById('cetak_struk').value = '0'"
                                class="btn w-full py-2.5 px-4 rounded-xl font-semibold text-xs bg-slate-800/80 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center gap-2 border border-white/10 disabled:opacity-40 disabled:cursor-not-allowed transition">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                            <span>Simpan Saja (Tanpa Struk)</span>
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- POS Script -->
<script>
    function posSystem() {
        const rawMenus = @json($rawMenus);

        return {
            menuList: rawMenus,
            searchQuery: '',
            selectedCategory: 'all',
            tipePesanan: 'Dine In',
            noMeja: '',
            statusPembayaran: 'lunas',
            uangDiterima: 0,
            cart: [],

            get filteredMenus() {
                return this.menuList.filter(item => {
                    const matchCategory = (this.selectedCategory === 'all') || (item.kategori_nama === this.selectedCategory);
                    const matchSearch = item.nama_menu.toLowerCase().includes(this.searchQuery.toLowerCase().trim());
                    return matchCategory && matchSearch;
                });
            },

            get totalBayar() {
                return this.cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
            },

            get kembalian() {
                if (!this.uangDiterima) return 0;
                return this.uangDiterima - this.totalBayar;
            },

            getItemQty(menuId) {
                const found = this.cart.find(item => item.menu_id === menuId);
                return found ? found.jumlah : 0;
            },

            addToCart(menu) {
                const existing = this.cart.find(item => item.menu_id === menu.id_menu);
                if (existing) {
                    existing.jumlah++;
                } else {
                    this.cart.push({
                        menu_id: menu.id_menu,
                        nama_menu: menu.nama_menu,
                        harga: menu.harga,
                        foto_url: menu.foto_url,
                        kategori_nama: menu.kategori_nama,
                        jumlah: 1,
                        catatan: '',
                    });
                }
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },

            increaseQty(menuId) {
                const item = this.cart.find(i => i.menu_id === menuId);
                if (item) item.jumlah++;
            },

            decreaseQty(menuId) {
                const index = this.cart.findIndex(i => i.menu_id === menuId);
                if (index !== -1) {
                    if (this.cart[index].jumlah > 1) {
                        this.cart[index].jumlah--;
                    } else {
                        this.cart.splice(index, 1);
                    }
                }
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },

            removeItem(menuId) {
                this.cart = this.cart.filter(i => i.menu_id !== menuId);
                this.$nextTick(() => {
                    if (window.lucide) lucide.createIcons();
                });
            },

            clearCart() {
                if (confirm('Kosongkan semua item yang sudah dipilih?')) {
                    this.cart = [];
                    this.uangDiterima = 0;
                }
            },

            formatRupiah(number) {
                return 'Rp ' + (number || 0).toLocaleString('id-ID');
            }
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
@endsection
