# 🚀 SYSTEM CONTEXT: SKRIPSI KEDAI BANG NANA

## 1. IDENTITAS PROYEK

- **Judul Skripsi:** Pengembangan Aplikasi Web dengan Fitur Self-Ordering dan Payment Gateway (Studi Kasus: Kedai Bang Nana Café and Resto).
- **Metode Pengembangan:** RAD (Rapid Application Development).
- **Tujuan:** Membangun sistem POS (Kasir) Hybrid yang melayani pesanan manual (di kasir) dan mandiri (Self-Ordering pelanggan via QR Code).

## 2. TECH STACK (STRICT)

- **Backend:** Laravel 12 (PHP 8.3).
- **Database:** MySQL.
- **Frontend:** Blade Templates + **Tailwind CSS** (Via Vite).
    - _Note:_ DILARANG menggunakan Bootstrap. Gunakan Utility Classes Tailwind sepenuhnya.
- **Payment Gateway:** Midtrans Snap (Mode Sandbox).
- **Icons:** Heroicons (SVG).
- **Server Environment:** Laragon (Localhost).

## 3. UI/UX DESIGN SYSTEM (TEMA: WARM/APPETIZING)

Agar tampilan sesuai selera pemilik kafe dan "enak dilihat", patuhi panduan ini:

- **Color Palette:**
    - **Primary (Brand):** `Amber` (Orange kekuningan). Gunakan `bg-amber-500` untuk tombol utama, `text-amber-600` untuk aksen.
    - **Neutral (Background):** `Slate`. Gunakan `bg-slate-50` untuk latar belakang halaman, `text-slate-800` untuk teks utama.
    - **Success:** `Emerald` (Hijau segar).
    - **Danger:** `Rose` (Merah lembut).
- **Component Style:**
    - **Card:** Background putih, `rounded-xl` (sudut tumpul), `shadow-sm` atau `shadow-md`.
    - **Button:** Rounded medium (`rounded-lg`), padding yang nyaman untuk sentuhan jari (Mobile First).
    - **Font:** Gunakan font bawaan Tailwind (Inter/Sans) yang bersih.

## 4. STRUKTUR DATABASE (FINAL & MIGRATED)

Jangan merubah struktur ini kecuali diminta. Semua Model sudah dibuat.

1.  **`users`**
    - PK: `id_user`
    - Cols: `username` (unique), `password`, `role` ('admin', 'kasir', 'pemilik', 'pelanggan').
    - _Note:_ Login menggunakan Username.
2.  **`kategoris`**
    - PK: `id_kategori`
    - Cols: `nama_kategori`.
3.  **`menus`**
    - PK: `id_menu`
    - FK: `kategori_id`
    - Cols: `nama_menu`, `deskripsi`, `harga` (bigint), `stok` (int), `foto` (string path), `is_available` (boolean).
4.  **`orders`**
    - PK: `id_order`
    - FK: `user_id_kasir` (nullable - jika self order)
    - Cols: `no_order` (string unik), `nama_pelanggan`, `total_bayar`, `tipe_pesanan` ('dine-in', 'take-away'), `status_order` ('pending', 'lunas', 'diproses', 'selesai').
5.  **`order_items`**
    - PK: `id_item`
    - FK: `order_id`, `menu_id`
    - Cols: `jumlah`, `harga_satuan`, `subtotal`, `catatan_khusus`.
6.  **`pembayarans`**
    - PK: `id_pembayaran`
    - FK: `order_id`
    - Cols: `snap_token` (untuk Midtrans), `metode_bayar`, `status_bayar`, `midtrans_log` (text), `waktu_bayar`.

## 5. KONFIGURASI SAAT INI (PROGRESS)

- [x] Instalasi Laravel & Setup `.env`.
- [x] Integrasi Midtrans (Server Key & Client Key Sandbox sudah terpasang di `.env` dan `config/midtrans.php`).
- [x] Migration Database Selesai.
- [x] Seeder Data Dummy (User Admin/Kasir/Pemilik + Menu Makanan) Selesai.
- [x] Custom `AuthController` dibuat (Login via Username & Redirect based on Role).
- [x] Setup Tailwind CSS (Vite) Selesai.

## 6. ALUR BISNIS & FEATURES

- **Role Pelanggan (Self-Service):**
    - Akses halaman tanpa login (Guest) atau scan QR Meja.
    - Pilih Menu (Add to Cart).
    - Checkout -> Isi Nama & No Meja.
    - Bayar via Midtrans Snap (Popup).
    - Status berubah jadi "Lunas/Diproses" otomatis via Callback (Webhooks).
- **Role Kasir:**
    - Dashboard pesanan masuk (Real-time atau Auto Refresh).
    - Terima pembayaran tunai (jika ada).
    - Ubah status pesanan (Diproses -> Selesai/Diantar).
    - Cetak Struk (Thermal Printer layout).
- **Role Admin:**
    - CRUD Master Data (Menu, Kategori, User).
- **Role Pemilik:**
    - Melihat Laporan Pendapatan (Harian/Bulanan).

## 7. ATURAN CODING (RULES)

1.  **Komentar Kode:** Gunakan Bahasa Indonesia agar mudah dimasukkan ke laporan skripsi.
2.  **Clean Code:** Gunakan Controller yang ramping. Pindahkan logika berat ke Service atau Model jika perlu.
3.  **UI/UX:** Pastikan tampilan **Mobile Responsive** karena target pengguna utama adalah pelanggan via HP.
4.  **Midtrans:** Selalu gunakan `config('midtrans.server_key')` jangan hardcode key di controller.

---

**INSTRUKSI UNTUK AI:**
Setiap kali saya meminta fitur baru, selalu referensikan struktur tabel di atas dan gunakan Tailwind CSS untuk UI-nya. Jangan tawarkan Bootstrap.
