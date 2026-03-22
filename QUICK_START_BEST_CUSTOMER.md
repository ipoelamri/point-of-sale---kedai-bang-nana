# 📊 Panduan Cepat: Fitur Pelanggan Terbaik

## 🎯 Akses Cepat

**Lokasi Menu**: Sidebar kiri → Ikon ⭐ **"Pelanggan Terbaik"**

---

## 📱 Halaman Utama

### Bagian 1: Statistik Ringkas (Atas)

Menampilkan 4 kartu informasi:

1. **Pelanggan Unik** - Jumleah pelanggan berbeda yang pernah membeli
2. **Total Transaksi** - Total pesanan yang selesai
3. **Total Pendapatan** - Total uang dari penjualan
4. **Rata-rata Transaksi** - Nilai rata-rata setiap pesanan

### Bagian 2: Filter & Kontrol (Tengah)

**Periode:**

- Pilih rentang waktu (7/30/60/90/365 hari)

**Urutkan:**

- Total Pengeluaran (siapa yang paling banyak habis)
- Jumlah Pesanan (siapa yang paling sering beli)
- Pesanan Terakhir (siapa yang baru kemarin membeli)

**Tombol:**

- 🔵 **Filter** - Terapkan filter baru
- 📥 **Export CSV** - Download data ke Excel

### Bagian 3: Tabel Ranking

| Kolom       | Makna                            |
| ----------- | -------------------------------- |
| 🏆          | Ranking dengan medal untuk top 3 |
| Nama        | Nama customer                    |
| Pesanan     | Berapa kali membeli              |
| Pengeluaran | Total uang yang dikeluarkan      |
| Rata-rata   | Rata-rata per transaksi          |
| Terakhir    | Kapan terakhir order             |
| Detail      | Klik untuk lihat riwayat         |

---

## 🔍 Halaman Detail Pelanggan

**Cara Masuk**: Klik "Lihat Detail" di tabel utama

### Bagian Atas: Statistik

5 kartu info detail:

1. **Total Pesanan** - Berapa kali customer membeli
2. **Total Pengeluaran** - Total uang yang dikeluarkan
3. **Rata-rata** - Nilai rata-rata setiap pesanan
4. **Pesanan Pertama** - Tanggal jadi customer
5. **Pesanan Terakhir** - Kapan terakhir membeli

### Bagian Bawah: Riwayat Pesanan

Tabel lengkap semua pesanan customer:

- Nomor pesanan
- Tanggal & waktu
- Jenis pesanan (dine-in/takeaway)
- Jumlah item
- Total harga
- Metode pembayaran
- Status ("✓ Lunas" / "⏳ Pending" / "✗ Gagal")
- Klik untuk detail lebih lanjut

---

## 📥 Export ke CSV

**Langkah:**

1. Di halaman utama, klik **"Export CSV"**
2. File otomatis download: `top-customers-[tanggal].csv`
3. Buka dengan Excel/LibreOffice/Google Sheets

**Data yang included:**

- Ranking
- Nama Pelanggan
- Total Pesanan
- Total Pengeluaran
- Rata-rata
- Pesanan Terakhir

---

## 💡 Use Cases Praktis

### Admin Kasir:

- Monitor pelanggan setia setiap hari
- Berikan special treatment pada top customers
- Analisis tren pembelian harian/mingguan

### Pemilik:

- Lihat performa bulanan pelanggan
- Identifikasi VIP customers untuk loyalty program
- Presentasi data ke stakeholder via CSV export
- Buat keputusan promosi berdasarkan data

### Kasir:

- Lihat pelanggan yang sering beli
- Tawarkan menu pilihan berdasarkan riwayat
- Update manajemen tentang top spenders

---

## ❓ FAQ

**Q: Kenapa data kosong?**
A: Pastikan ada pesanan dengan status "selesai" dalam periode yang dipilih.

**Q: Bagaimana cara lihat semua pelanggan?**
A: Gunakan periode 365 hari untuk lihat sepanjang tahun.

**Q: Data bisa di-sort bagaimana?**
A: 3 cara: Total Pengeluaran (default), Jumlah Pesanan, Pesanan Terakhir

**Q: Bisa export data?**
A: Ya! Klik tombol "Export CSV" dan download langsung.

**Q: Detail pelanggan bisa lihat apa saja?**
A: Statistik lengkap + riwayat SEMUA pesanan customer + status pembayaran.

**Q: Jika ingin lihat pesanan detail?**
A: Di halaman detail, klik nomor pesanan → akan ke halaman order details.

---

## ⚡ Tips & Tricks

1. **Top Customers Special Service**
    - Lihat top 5 pelanggan
    - Personal greeting ketika datang
    - Tawarkan item favorit mereka

2. **Monitor Inactive Customers**
    - Filter 30 hari terakhir
    - Cek siapa yang tidak ada di list
    - Reach out untuk retention

3. **Revenue Analysis**
    - Check total revenue vs pelanggan unik
    - Hitung loyalty rate
    - Plan promosi strategis

4. **Menu Optimization**
    - Export data
    - Lihat menu apa yang paling diorder pelanggan top
    - Optimize menu berdasarkan preferences

---

## 🎨 Visual Guide

```
┌─────────────────────────────────────────┐
│  📊 Pelanggan Terbaik                   │
│  Analisis dan laporan pelanggan terbaik │
└─────────────────────────────────────────┘

📊 STATISTIK RINGKAS
┌──────────┬──────────┬──────────┬──────────┐
│ 👥 Unik  │ 📋 Trans │ 💰 Pend  │ 📊 Rata  │
│ 250      │ 1,200    │ 45M      │ 37,500   │
└──────────┴──────────┴──────────┴──────────┘

🎯 FILTER & KONTROL
┌─────────────┐ ┌─────────────┐ ┌─────┐ ┌─────┐
│ Periode: 30 │ │ Urut: Spend │ │Filt │ │Expor│
└─────────────┘ └─────────────┘ └─────┘ └─────┘

🏆 RANKING PELANGGAN
┌────┬────────────┬─────┬──────────┬────────┬──────────────┐
│ 🥇 │ Budi Santoso│ 125 │ 15,000K  │ 120K   │ 2026-01-01   │
│ 🥈 │ Siti Amelia │ 98  │ 12,500K  │ 127K   │ 2026-01-02   │
│ 🥉 │ Ahmad Wijaya│ 87  │ 10,000K  │ 115K   │ 2026-01-03   │
│  4 │ Dewi Kusuma │ 76  │ 9,500K   │ 125K   │ 2026-01-02   │
│  5 │ Rudi Hermawa│ 65  │ 8,000K   │ 123K   │ 2026-01-01   │
└────┴────────────┴─────┴──────────┴────────┴──────────────┘

[Pagination: 1 2 3 4 5 >>]
```

---

## 📞 Bantuan

**Masalah?**

- Cek file `BEST_CUSTOMER_FEATURE.md` untuk detail lengkap
- Refresh halaman (F5)
- Clear cache browser
- Hubungi admin sistem

---

**Siap Digunakan! 🚀**
