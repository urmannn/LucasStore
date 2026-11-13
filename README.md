# NusaStore — Laravel E-Commerce Portfolio

Aplikasi web **E-Commerce** modern berbasis **Laravel 13**, **Blade**, dan **Tailwind CSS v4** dengan tema visual **Hijau Emerald & Orange**, dilengkapi foto produk nyata (*laptop, smartphone, tissue, pakaian, aksesoris*) dan simulator **Payment Gateway Mock (Sandbox)** interaktif.

## Fitur Utama

### 1. Desain & Tema Hijau & Orange (Green & Orange Theme)
- Identitas brand segar, profesional, dan eye-catching dengan paduan warna hijau zamrud (`emerald`) dan oranye cerah (`orange`).
- Elemen interaktif: header modern dengan logo gradien, badge jumlah keranjang menyala, banner hero bernuansa hangat, serta tombol aksi bertema belanja.

### 2. Foto Produk Real (Real Product Catalog)
Katalog terisi foto produk nyata beresolusi tinggi di `public/images/products/`:
- **Laptop**: Laptop Ultrabook 14 Inch Core i7 Slim
- **Handphone**: Smartphone Flagship 5G 256GB AMOLED
- **Tissue**: Tissue Wajah Premium 3-Ply 250 Sheets
- **Mechanical Keyboard**: Wireless Mechanical Keyboard 75% RGB
- **Headphone**: Headphone ANC Studio Pro Wireless
- **Pakaian & Fashion**: Kemeja Casual Oxford Katun Pria, Kaos Polos Combed 24s, Sepatu Sneakers Streetwear
- **Aksesoris & Rumah Tangga**: Jam Tangan Chronograph Kulit, Tas Ransel Laptop Anti Air, Lampu Meja Touch Dimmer, Tumbler Vacuum Insulated

### 3. Fitur Mock Payment Gateway (Sandbox Simulator)
Halaman pembayaran khusus di `/orders/{order}/payment` menyerupai payment gateway resmi (Midtrans/Xendit):
- **QRIS Dinamis**: Tampilan grafis QR Code standar nasional dengan logo NusaStore dan tombol instan *"Simulasikan Scan & Bayar QRIS"*.
- **Virtual Account (VA)**: Menampilkan nomor VA unik (misal `8808...`) dengan tombol interaktif *"Salin Nomor VA"* (copy-to-clipboard) beserta petunjuk transfer m-Banking & ATM.
- **Cash on Delivery (COD)**: Panduan penyiapan uang tunai pas kepada kurir saat pengantaran.
- **Simulator Action Controls**:
  - Tombol **⚡ Simulasikan Pembayaran Berhasil** (mengubah status menjadi Lunas secara realtime).
  - Tombol **⚠️ Simulasikan Transaksi Ditolak** (pengujian skenario kegagalan pembayaran).
  - Tombol **✕ Batalkan Pesanan** (otomatis mengembalikan stok produk ke inventaris).
- Countdown timer 24 jam interaktif yang berdetik setiap detik.

### 4. Fitur Pelanggan & Admin
- **Keranjang & Checkout Aman**: Validasi stok real-time, `lockForUpdate()`, dan `DB::transaction()` untuk mencegah minus stok saat *race condition*.
- **Riwayat Pesanan**: Lacak status pesanan (`pending`, `paid`, `processing`, `shipped`, `completed`, `cancelled`).
- **Admin Dashboard (`/admin`)**: Pantau total omset penjualan lunas, jumlah pesanan, stok menipis, CRUD kategori & produk dengan upload foto, serta pembaruan status pesanan.

## Cara Menjalankan Aplikasi

1. Jalankan migrasi dan seeder data demo:
   ```bash
   php artisan migrate:fresh --seed
   ```
2. Build aset Tailwind CSS:
   ```bash
   npm run build
   ```
3. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```
4. Buka di browser: `http://127.0.0.1:8000`

## Akun Demo Siap Pakai

- **Admin**: `admin@example.com` / `password`
- **Customer**: `customer@example.com` / `password`

## Pengujian Otomatis

Jalankan test suite PHPUnit:
```bash
php artisan test
```
*Hasil pengujian saat ini: 15 tests, 81 assertions PASSED.*
