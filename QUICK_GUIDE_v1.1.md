# 📖 PANDUAN CEPAT - Fitur Baru Laporan Pelanggan Terbaik v1.1

## 🎯 Akses Menu

1. **Login** ke sistem POS
2. Di sidebar menu, klik **⭐ "Pelanggan Terbaik"**
3. Halaman akan terbuka dengan halaman utama

---

## 🎛️ FILTER PANEL (Bagian Baru)

### Bagian 1: Pilihan Filter

```
┌─────────────────────────────────────────────────┐
│ 📅 Rentang Waktu  │ 🏆 Batasan Peringkat      │
├─────────────────────────────────────────────────┤
│ ▼ Bulanan (30H)   │ ▼ Top 15                  │
│   Harian (1H)     │   Top 5, 10, 15, 20, 30,50│
│   Tahunan (365H)  │                            │
└─────────────────────────────────────────────────┘

┌────────────────────────┬──────────────────┐
│ ⬇️ Urutkan             │ ✓ Tampilkan      │
├────────────────────────┤                  │
│ ▼ Total Pengeluaran    │ [Button Pink]    │
│   Jumlah Pesanan       │                  │
│   Pesanan Terakhir     │                  │
└────────────────────────┴──────────────────┘
```

### Langkah-Langkah:

1️⃣ **Pilih Rentang Waktu:**

- **Harian** = Data hari ini (1 hari)
- **Bulanan** = Data 30 hari terakhir (Default)
- **Tahunan** = Data 365 hari (1 tahun)

2️⃣ **Pilih Batasan Peringkat:**

- **Top 5** = Tampilkan 5 pelanggan terbaik
- **Top 10** = Tampilkan 10 pelanggan terbaik
- **Top 15** = Tampilkan 15 pelanggan (Default)
- **Top 20** = Tampilkan 20 pelanggan
- **Top 30** = Tampilkan 30 pelanggan
- **Top 50** = Tampilkan 50 pelanggan

3️⃣ **Urutkan Berdasarkan:** (Opsional)

- **Total Pengeluaran** = Siapa yang paling banyak habis uang (Default)
- **Jumlah Pesanan** = Siapa paling sering beli
- **Pesanan Terakhir** = Siapa yang baru-baru ini beli

4️⃣ **Klik "✓ Tampilkan":**

- Database akan diquery ulang
- Tabel akan terupdate dengan data baru
- Statistik akan refresh
- Pagination reset ke halaman 1

---

## 📊 HASIL TABEL

**Setelah klik "Tampilkan", tabel akan menampilkan:**

| 🏆  | Nama Pelanggan | 📋 Pesanan | 💰 Total | 📊 Rata-rata | 🕐 Terakhir | Detail  |
| --- | -------------- | ---------- | -------- | ------------ | ----------- | ------- |
| 🥇  | Budi Santoso   | 125        | Rp 15jt  | Rp 120rb     | 01/03       | [Lihat] |
| 🥈  | Siti Amelia    | 98         | Rp 12jt  | Rp 127rb     | 28/02       | [Lihat] |
| 🥉  | Ahmad Wijaya   | 87         | Rp 10jt  | Rp 115rb     | 27/02       | [Lihat] |
| 4   | Dewi Kusuma    | 76         | Rp 9jt   | Rp 125rb     | 26/02       | [Lihat] |
| 5   | Rudi Hermawa   | 65         | Rp 8jt   | Rp 123rb     | 25/02       | [Lihat] |

**Keterangan:**

- 🏆 = Ranking dengan medal untuk top 3 (🥇🥈🥉)
- Nama Pelanggan = Nama dari customer
- 📋 Pesanan = Berapa kali membeli
- 💰 Total = Total uang yang dikeluarkan
- 📊 Rata-rata = Rata-rata per transaksi
- 🕐 Terakhir = Kapan terakhir membeli
- Detail = Klik untuk lihat riwayat lengkap

---

## 📥 EXPORT OPTIONS (Bagian Baru)

### Tombol Export (Di bawah filter):

```
┌────────────────────────────────────────────────┐
│ 📊 Unduh CSV          │ 📄 Unduh PDF          │
│ [Green Button]        │ [Red Button]          │
└────────────────────────────────────────────────┘
```

---

## 📊 OPSI 1: UNDUH CSV

**Cara Menggunakan:**

1. Klik tombol **"📊 Unduh CSV"**
2. File `laporan-pelanggan-terbaik-[tanggal].csv` akan otomatis download
3. Buka file dengan Excel atau aplikasi spreadsheet lainnya

**File berisi:**

- Kolom: Peringkat, Nama Pelanggan, Total Pesanan, Total Pengeluaran, Rata-rata, Pesanan Terakhir
- Format: UTF-8 dengan separator semicolon (;)
- Excel-compatible

**Gunakan untuk:**

- Presentasi ke pemilik/manajemen
- Import ke software lain
- Backup data
- Analisis lebih lanjut di Excel

---

## 📄 OPSI 2: UNDUH PDF (FITUR BARU)

**Cara Menggunakan:**

### Langkah 1: Buka Preview PDF

1. Klik tombol **"📄 Unduh PDF"**
2. Tab/window baru akan terbuka dengan preview laporan

### Langkah 2: Lihat Laporan PDF

Laporan akan berisi:

- **Header** dengan logo Kedai Bang Nana
- **Informasi** laporan (tanggal, periode yang dipilih, top limit)
- **Statistik Ringkas** (4 kartu):
    - 👥 Pelanggan Unik = Berapa pelanggan berbeda
    - 📋 Total Transaksi = Total pesanan
    - 💰 Total Pendapatan = Total revenue
    - 📊 Rata-rata Transaksi = Rata-rata per transaksi
- **Tabel Lengkap** dengan ranking pelanggan terbaik
- **Footer** dengan informasi copyright

### Langkah 3: Simpan atau Cetak

Di halaman preview PDF, ada tombol **"🖨️ Cetak/Simpan sebagai PDF"**

**Opsi:**

- 🖨️ **Cetak ke Printer** - Kirim langsung ke printer fisik
- 💾 **Simpan sebagai PDF** - Simpan file PDF ke komputer
    - Di dialog print, pilih "Save as PDF" atau "Microsoft Print to PDF"
    - Pilih lokasi penyimpanan
    - Klik "Simpan"

**Gunakan untuk:**

- Arsip laporan bulanan/harian
- Kirim via email
- Presentasi ke klien
- Dokumentasi official

---

## 🎯 CONTOH PENGGUNAAN SKENARIO

### Skenario 1: Pelanggan Terbaik Bulan Ini

```
1. Periode: Bulanan (30 hari) ✓
2. Top Limit: Top 10 ✓
3. Sort: Total Pengeluaran ✓
4. Klik "Tampilkan" ✓
5. Hasil: Top 10 pelanggan dengan spending terbesar bulan ini
6. Klik "Unduh PDF" untuk laporan formal
```

### Skenario 2: Pelanggan Setia Tahunan

```
1. Periode: Tahunan (365 hari) ✓
2. Top Limit: Top 20 ✓
3. Sort: Jumlah Pesanan ✓
4. Klik "Tampilkan" ✓
5. Hasil: Top 20 pelanggan paling sering membeli sepanjang tahun
6. Unduh CSV untuk analisis lebih lanjut di Excel
```

### Skenario 3: Pelanggan Aktif Hari Ini

```
1. Periode: Harian (1 hari) ✓
2. Top Limit: Top 5 ✓
3. Sort: Pesanan Terakhir ✓
4. Klik "Tampilkan" ✓
5. Hasil: 5 pelanggan yang paling baru membeli hari ini
```

---

## ⚡ TIPS & TRIK

### 💡 Tip 1: Quick Reports

- **Laporan Harian**: Gunakan Top 5, Periode Harian
- **Laporan Mingguan**: Top 10, Sort by Spending
- **Laporan Bulanan**: Top 15, Periode Bulanan
- **Laporan Tahunan**: Top 20, Periode Tahunan

### 💡 Tip 2: Export Preference

- **Untuk manajemen**: Gunakan PDF (lebih formal)
- **Untuk analisis**: Gunakan CSV (lebih flexible di Excel)
- **Untuk arsip**: Gunakan PDF (mudah stored)

### 💡 Tip 3: Loyalty Program

- Identifikasi Top 5 pelanggan setiap bulan
- Berikan special treatment/discount
- Monitor dengan laporan tahunan
- Use CSV untuk track trend

### 💡 Tip 4: Mobile Usage

- Desktop: Semua fungsi optimal
- Tablet: Responsive design work well
- Mobile: Filter dan tabel responsive
- Print di mobile: Khusus PDF format

---

## ❓ FAQ

**Q: Berapa lama data ter-update?**
A: Real-time, langsung dari database. Klik "Tampilkan" untuk refresh.

**Q: Bisa filter custom periode?**
A: Sekarang ada 3 opsi (Harian/Bulanan/Tahunan). Custom akan ditambah di versi mendatang.

**Q: CSV buka di mana?**
A: Bisa dibuka dengan Excel, Google Sheets, atau text editor manapun.

**Q: PDF bisa dicetak langsung?**
A: Ya! Di preview PDF ada tombol "Cetak", bisa langsung ke printer.

**Q: Apa beda CSV vs PDF?**
A: CSV = data format untuk analisis Excel. PDF = laporan formal siap print.

**Q: Bisa lihat riwayat detail pelanggan?**
A: Ya! Di tabel, klik "Lihat Detail" untuk riwayat lengkap pelanggan.

**Q: File seret berapa ukuran?**
A: Kecil (~10-50KB tergantung top limit dan periode).

**Q: Bisa akses dari mobile?**
A: Ya! Semuanya responsive di smartphone/tablet.

**Q: Ada limit data maksimal?**
A: Top limit terbatas hingga 50 pelanggan per laporan.

**Q: Berapa role yang bisa akses?**
A: Admin, Kasir, dan Pemilik - semua bisa akses.

---

## 🖨️ TIPS PRINTING

### Chrome/Edge:

1. Klik "📄 Unduh PDF"
2. Klik "🖨️ Cetak/Simpan sebagai PDF" di preview
3. Setting:
    - Destination: "Save as PDF" atau printer
    - Paper size: A4
    - Margin: Default (Normal)
4. Klik "Save" atau "Print"

### Firefox:

1. Sama seperti Chrome/Edge
2. Di preview bisa langsung Ctrl+P untuk print dialog

### Safari (Mac):

1. Klik "📄 Unduh PDF"
2. Command+P untuk print
3. Pilih "Save as PDF" di dropdown

---

## 📌 SHORTCUT / KEYBOARD

- **Ctrl+P** = Print terakhir kali
- **Ctrl+S** = Save halaman
- **F5** = Refresh data
- **Ctrl+A** = Select all di tabel
- **Ctrl+C** = Copy data tabel

---

## 🎨 COLOR LEGEND

| Warna                          | Makna                              |
| ------------------------------ | ---------------------------------- |
| 🟢 Green (CSV)                 | Download format data (spreadsheet) |
| 🔴 Red (PDF)                   | Download format dokumen (print)    |
| 🟣 Pink (Tampilkan)            | Action primary, apply filter       |
| 🏆 Gold/Silver/Bronze (🥇🥈🥉) | Top 3 ranking                      |

---

**Sekarang Anda siap menggunakan Laporan Pelanggan Terbaik v1.1! 🎉**

_Untuk pertanyaan lebih lanjut, hubungi admin sistem._
