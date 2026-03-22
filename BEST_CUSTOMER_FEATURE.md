# 📊 Fitur Pelanggan Terbaik (Best Customer)

## Deskripsi Fitur

Fitur **Pelanggan Terbaik** adalah sistem analitik yang memberikan insight mendalam tentang pelanggan paling berharga berdasarkan aktivitas pembelian mereka. Fitur ini membantu admin, kasir, dan pemilik dalam membuat keputusan bisnis yang lebih baik.

## Akses dan Izin

### Pengguna yang Dapat Mengakses:

- ✅ **Admin** - Akses penuh
- ✅ **Kasir** - Akses penuh
- ✅ **Pemilik** - Akses penuh

### Navigasi:

1. Login ke sistem
2. Klik **"Pelanggan Terbaik"** di sidebar menu
3. Halaman utama akan menampilkan statistik ringkas dan daftar pelanggan terbaik

## Fitur Utama

### 1. Dashboard Ringkas

Menampilkan 4 statistik utama:

- **Pelanggan Unik**: Jumlah pelanggan berbeda
- **Total Transaksi**: Jumlah seluruh pesanan
- **Total Pendapatan**: Total uang yang masuk
- **Rata-rata Transaksi**: Nilai rata-rata per pesanan

### 2. Filter dan Urutan

Users dapat memfilter data berdasarkan:

#### Periode:

- 7 Hari Terakhir
- 30 Hari Terakhir (Default)
- 60 Hari Terakhir
- 90 Hari Terakhir
- 1 Tahun Terakhir

#### Urutkan Berdasarkan:

- **Total Pengeluaran** (Default) - Pelanggan dengan pengeluaran terbesar
- **Jumlah Pesanan** - Pelanggan paling sering membeli
- **Pesanan Terakhir** - Pelanggan yang baru saja membeli

### 3. Ranking Pelanggan

Tabel menampilkan:

- 🏆 **Ranking** - Posisi dengan medal (🥇🥈🥉 untuk top 3)
- **Nama Pelanggan** - Nama customer
- **Total Pesanan** - Jumlah pembelian
- **Total Pengeluaran** - Total uang yang dikeluarkan
- **Rata-rata** - Nilai rata-rata per pembelian
- **Pesanan Terakhir** - Kapan terakhir membeli
- **Aksi** - Tombol untuk melihat detail

### 4. Halaman Detail Pelanggan

Klik "Lihat Detail" untuk melihat:

**Statistik Pelanggan:**

- Total Pesanan
- Total Pengeluaran
- Rata-rata Pengeluaran per Pesanan
- Tanggal Pesanan Pertama
- Tanggal Pesanan Terakhir

**Riwayat Pesanan Lengkap:**

- Nomor Pesanan
- Tanggal dan Waktu
- Tipe Pesanan (dine-in/takeaway/delivery)
- Jumlah Item
- Total Pembayaran
- Metode Pembayaran
- Status Pembayaran
- Link untuk melihat detail pesanan

### 5. Export ke CSV

Tombol **"Export CSV"** memungkinkan users untuk:

- Download data pelanggan terbaik
- Format: CSV (Excel kompatibel)
- Nama file: `top-customers-[TANGGAL].csv`
- Termasuk: Ranking, Nama, Total Pesanan, Total Pengeluaran, Rata-rata, Pesanan Terakhir

## Database Queries

### Query Utama

```sql
SELECT
    nama_pelanggan,
    COUNT(id_order) as total_orders,
    SUM(total_bayar) as total_spending,
    AVG(total_bayar) as avg_spending,
    MAX(created_at) as last_order_date,
    MIN(created_at) as first_order_date
FROM orders
WHERE status_order = 'selesai'
    AND nama_pelanggan != ''
    AND created_at >= [start_date]
GROUP BY nama_pelanggan
ORDER BY total_spending DESC
LIMIT 15
```

## File-File yang Dibuat

### Controller

- `app/Http/Controllers/BestCustomerController.php`
    - Method: `index()` - Tampilkan list pelanggan terbaik
    - Method: `show()` - Tampilkan detail pelanggan
    - Method: `export()` - Export data ke CSV

### Views

- `resources/views/best-customer/index.blade.php` - Halaman utama
- `resources/views/best-customer/show.blade.php` - Halaman detail

### Routes

- `GET /best-customer` - Halaman utama (best-customer.index)
- `GET /best-customer/{customerName}` - Detail pelanggan (best-customer.show)
- `GET /best-customer/export/csv` - Download CSV (best-customer.export)

### Navigation

- Ditambahkan menu "Pelanggan Terbaik" di sidebar (layouts/app.blade.php)

## Cara Penggunaan

### 1. Melihat Pelanggan Terbaik

```
- Klik "Pelanggan Terbaik" di sidebar
- Pilih periode yang ingin dilihat
- Pilih urutan (Total Pengeluaran/Jumlah Pesanan/Pesanan Terakhir)
- Klik tombol "Filter"
```

### 2. Melihat Detail Pelanggan

```
- Di halaman list, klik "Lihat Detail" pada baris pelanggan
- Akan menampilkan statistik lengkap dan riwayat pesanan
- Bisa filter periode di halaman detail
- Bisa klik nomor pesanan untuk melihat detail lebih lanjut
```

### 3. Export Data

```
- Di halaman utama, klik tombol "Export CSV"
- File akan download otomatis dalam format CSV
- Buka dengan Excel atau aplikasi spreadsheet lainnya
```

## Fitur Keamanan

✅ **Autentikasi**: Hanya user yang login yang bisa akses
✅ **Authorization**: Accessible untuk roles: admin, kasir, pemilik
✅ **Data Filtering**: Hanya menampilkan pesanan dengan status "selesai"
✅ **Parameter Sanitization**: URL parameters di-encode untuk keamanan

## Performa

### Optimasi Query

- Menggunakan database aggregation (`COUNT`, `SUM`, `AVG`)
- Grouped by `nama_pelanggan` untuk efisiensi
- Filtration pada database level
- Pagination: 15 items per halaman

### Caching Opportunity

Jika diperlukan performa lebih tinggi, bisa ditambahkan:

```php
$bestCustomers = Cache::remember('best_customers_' . $period,
    60, // Cache 1 jam
    function () { /* query */ }
);
```

## Testing

### Manual Testing Checklist

- [ ] Login dengan berbagai role (admin, kasir, pemilik)
- [ ] Verifikasi semua role bisa akses fitur
- [ ] Test filter berdasarkan periode
- [ ] Test urutan berdasarkan berbagai kriteria
- [ ] Test pagination
- [ ] Test export CSV
- [ ] Test klik "Lihat Detail"
- [ ] Test halaman detail dengan pagination
- [ ] Test dengan data kosong (tidak ada pesanan)
- [ ] Test render waktu dengan berbagai periode

## Future Features (Opsional)

1. **Chart/Grafik**
    - Pie chart untuk top 5 pelanggan
    - Bar chart untuk trend pembelian

2. **Lebih Detail Analisis**
    - Menu favorit pelanggan
    - Preferensi tipe pesanan (dine-in vs takeaway)
    - Jam-jam peak untuk setiap pelanggan

3. **Segmentasi Pelanggan**
    - VIP Customers (frekuensi tinggi, spending tinggi)
    - Dormant Customers (lama tidak membeli)
    - At-Risk Customers (spending menurun)

4. **Loyalty Program**
    - Badge untuk pelanggan setia
    - Reward/discount untuk top customers

5. **Notifikasi**
    - Alert ketika ada pelanggan baru yang menjadi top 10
    - Alert ketika pelanggan lama tidak membeli dalam waktu lama

## Troubleshooting

### Halaman Kosong?

- Pastikan ada pesanan dengan status "selesai"
- Cek filter periode, mungkin terlalu ketat
- Pastikan pesanan memiliki nama_pelanggan (tidak kosong)

### Export Tidak Bekerja?

- Checking storage permissions
- Pastikan browser mengizinkan download
- Cobakan dengan browser lain

### Data Tidak Update?

- Clear browser cache
- Refresh halaman (F5)
- Cek database untuk orderan terbaru

## Contact & Support

Untuk pertanyaan atau issue, hubungi tim development atau admin sistem.

---

**Last Updated**: March 1, 2026
**Version**: 1.0
