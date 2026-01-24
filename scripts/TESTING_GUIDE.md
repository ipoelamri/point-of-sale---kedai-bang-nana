# 🧪 TESTING GUIDE - Self-Ordering & Payment

Panduan lengkap untuk testing aplikasi POS dengan fitur self-ordering dan Midtrans Snap payment.

---

## 🎯 Test Scenario 1: Customer Flow (Self-Order via Web)

### Step 1: Akses Menu Publik

```
URL: http://localhost:8000/menu
Expected: Halaman menu dengan grid layout 4 kolom, menampilkan semua menu tersedia
Verifikasi:
- ✓ Gambar menu tampil
- ✓ Harga ditampilkan dengan format Rp
- ✓ Tombol "Tambah" responsive
- ✓ Counter keranjang update
```

### Step 2: Add to Cart

```
Action: Klik tombol "Tambah" pada beberapa menu dengan quantity berbeda
Expected: Alert "Menu ditambahkan ke keranjang"
Verifikasi:
- ✓ Counter keranjang bertambah
- ✓ Session menyimpan cart data
```

### Step 3: View Cart

```
URL: http://localhost:8000/cart
Action: Klik tombol "Lihat Keranjang"
Expected: Halaman cart menampilkan semua items
Verifikasi:
- ✓ Nama menu, harga, jumlah, subtotal tampil
- ✓ Total dihitung benar (dengan PPN 10%)
- ✓ Tombol "Hapus" berfungsi
- ✓ Tombol "Lanjut Belanja" dan "Checkout"
```

### Step 4: Checkout

```
URL: http://localhost:8000/checkout
Action: Isi form:
  - Nama Pelanggan: "Budi Santoso"
  - Tipe Pesanan: "Dine-in"
  - No Meja: "5"
Expected: Redirect ke halaman pembayaran
Verifikasi:
- ✓ Form validasi (nama required)
- ✓ Order dibuat di database (lihat: SELECT * FROM orders)
- ✓ Order items dibuat (lihat: SELECT * FROM order_items WHERE order_id=X)
- ✓ No order generate format: ORD-YYYYMMDDhhmmss-XXX
```

### Step 5: Pilih Metode Pembayaran

```
URL: http://localhost:8000/order/{id}/payment
Expected: Card dengan pilihan metode pembayaran
Action: Klik card "Pembayaran Online (Midtrans)"
Expected: Redirect ke /payment/{id}/snap
```

### Step 6: Midtrans Snap Payment

```
URL: http://localhost:8000/payment/{id}/snap
Expected: Halaman loading → Snap popup otomatis terbuka
Action: Klik tombol "Buka Jendela Pembayaran" jika popup tidak muncul
Verifikasi:
- ✓ Snap token tergenerate (lihat DB: pembayarans table, snap_token column)
- ✓ Popup Midtrans muncul dengan detail order
```

### Step 7: Bayar dengan Sandbox Credentials

```
Dalam popup Midtrans:
1. Pilih metode: "Kartu Kredit"
2. Isi:
   - Nomor: 4111111111111111 (test card)
   - Bulan/Tahun: 12/25
   - CVC: 123
3. Klik "Bayar"

Expected: Popup menunjukkan "Pembayaran Berhasil"
Verifikasi:
- ✓ Status berubah di database
- ✓ Webhook callback dari Midtrans terproses
```

### Step 8: Order Confirmation

```
Expected: Redirect otomatis ke /payment/finish
Halaman menampilkan:
- ✓ "Pembayaran Berhasil" header
- ✓ Bukti pesanan (invoice)
- ✓ Tombol "Pesan Lagi" dan "Print Bukti"

Database Check:
- order.status_order = "lunas"
- pembayaran.status_bayar = "lunas"
- pembayaran.waktu_bayar = filled
- pembayaran.metode_bayar = "credit_card"
```

### Step 9: Print Receipt

```
Action: Klik "Print Bukti"
Expected: Print dialog muncul, tampilkan struk termal format 80mm
Verifikasi:
- ✓ Header: Kedai Bang Nana
- ✓ Order details tertulis lengkap
- ✓ Item list dengan harga
- ✓ Total dengan PPN
- ✓ Status pembayaran
```

---

## 🧑‍💼 Test Scenario 2: Kasir Dashboard & Order Management

### Step 1: Login sebagai Kasir

```
URL: http://localhost:8000/login
Username: kasir
Password: (sesuai db)

Expected: Redirect ke /dashboard
Verifikasi: ✓ Sidebar menampilkan menu "Pesanan"
```

### Step 2: Akses Kasir Dashboard

```
URL: http://localhost:8000/kasir/pesanan
Expected: Halaman dengan list pesanan
Verifikasi:
- ✓ Tampil semua pesanan dengan status berbeda
- ✓ Ada tabs: Semua, Menunggu Pembayaran, Lunas, Sedang Diproses
- ✓ Auto-refresh setiap 30 detik
- ✓ Real-time clock di header
```

### Step 3: Filter by Status

```
Action: Klik tab "Lunas"
Expected: Hanya pesanan dengan status "lunas" tampil
Verifikasi: ✓ Filter berfungsi, URL update dengan ?status=lunas
```

### Step 4: Update Order Status

```
Action: Di pesanan yang berstatus "Lunas", klik tombol "Mulai Proses"
Expected: Status berubah menjadi "Diproses"
Verifikasi:
- ✓ Database update: order.status_order = "diproses"
- ✓ order.user_id_kasir = kasir login id
- ✓ Alert "Status pesanan berhasil diperbarui"
```

### Step 5: View Detail

```
Action: Klik "Lihat Detail" pada salah satu pesanan
Expected: Halaman detail pesanan terbuka
Verifikasi:
- ✓ Informasi lengkap (pelanggan, tipe, kasir)
- ✓ Daftar items dengan gambar, harga, jumlah
- ✓ Info pembayaran (metode, status, waktu)
- ✓ Sidebar dengan ringkasan total
- ✓ Tombol update status & print
```

### Step 6: Update Status from Detail Page

```
Action: Dropdown "Pilih Status" → select "Selesai" → click "Update"
Expected: Status pesanan berubah ke "Selesai"
Verifikasi:
- ✓ Button berubah jadi "✓ Pesanan Selesai" (disabled)
- ✓ Database updated
```

### Step 7: Print Struk

```
Action: Klik "Print Struk"
Expected: Tab baru terbuka, print dialog otomatis muncul
Verifikasi:
- ✓ Struk format 80mm thermal printer
- ✓ Semua info lengkap & rapi
- ✓ Bisa print ke printer atau simpan sebagai PDF
```

---

## 🔍 Test Scenario 3: Error Handling & Edge Cases

### Test 3A: Empty Cart Checkout

```
Action: Clear cart, coba akses /checkout
Expected: Redirect ke /menu dengan error "Keranjang kosong"
```

### Test 3B: Invalid Checkout Form

```
Action: Form checkout → tidak isi nama pelanggan → submit
Expected: Validation error ditampilkan di form
```

### Test 3C: Session Timeout

```
Action: Add to cart → bersihkan session → akses cart
Expected: Keranjang kosong, bisa refresh dan mulai ulang
```

### Test 3D: Payment Cancellation

```
Action: Midtrans payment → klik X/close popup
Expected: Redirect ke payment page, bisa retry payment
Database: pembayaran.status_bayar tetap "pending"
```

---

## 📊 Database Verification Queries

Gunakan query ini untuk verify data:

```sql
-- Lihat pesanan terbaru
SELECT * FROM orders ORDER BY created_at DESC LIMIT 5;

-- Lihat items pesanan
SELECT oi.*, m.nama_menu FROM order_items oi
JOIN menus m ON oi.menu_id = m.id_menu
WHERE oi.order_id = 1;

-- Lihat pembayaran
SELECT * FROM pembayarans ORDER BY created_at DESC LIMIT 5;

-- Lihat cart session (jika tersimpan di database)
SELECT * FROM sessions WHERE created_at > NOW() - INTERVAL 1 HOUR;

-- Count pesanan by status
SELECT status_order, COUNT(*) as jumlah FROM orders GROUP BY status_order;
```

---

## 🛠️ Debugging Tips

### Midtrans Issues:

```
1. Check .env: MIDTRANS_SERVER_KEY & MIDTRANS_CLIENT_KEY
2. Check config/midtrans.php loaded correctly
3. Check browser console untuk Snap script error
4. Enable verbose logging: MIDTRANS_IS_SANITIZED=false (temporary)
```

### Payment Not Updated:

```
1. Check webhook endpoint accessible
2. Verify signature validation di controller
3. Check Midtrans webhook configuration di dashboard
4. Look at midtrans_log column di pembayarans table
```

### Cart Issues:

```
1. Check browser cookies/session enabled
2. Verify session driver in .env (file/database)
3. Check storage/framework/sessions/ folder writable
```

### Image Not Showing:

```
1. Check symlink: php artisan storage:link
2. Verify file exists: storage/app/public/fotos/
3. Check foto path di menus table
4. Verify public/storage symlink created
```

---

## ✅ Checklist Sebelum Go Live

- [ ] Test semua fitur dengan minimal 3 pesanan
- [ ] Verify database integrity (constraints, relationships)
- [ ] Test Midtrans payment dengan multiple card types
- [ ] Test kasir dashboard dengan concurrent access
- [ ] Test print struk ke berbagai printer
- [ ] Check error logging (storage/logs/)
- [ ] Verify responsiveness di mobile (test di HP)
- [ ] Load testing: simulate multiple customers
- [ ] Security: test CSRF protection, input validation
- [ ] Update .env untuk production mode
- [ ] Setup backup strategy untuk database
- [ ] Configure webhook URL di Midtrans production

---

**Last Updated: 24 Jan 2026**
