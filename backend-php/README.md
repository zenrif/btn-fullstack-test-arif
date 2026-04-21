# 🐘 Backend PHP — CodeIgniter 4 (CRUD Produk & Autentikasi)

> **Soal 6 & 7** dari Technical Test BTN Fullstack Developer

---

## 📋 Tentang Project

Aplikasi web PHP menggunakan **CodeIgniter 4** yang mencakup dua fitur utama:

1. **CRUD Produk** (Soal 6) — Tambah, lihat, edit, hapus produk dengan standar keamanan perbankan
2. **Sistem Login** (Soal 7) — Autentikasi dengan `password_hash()` bcrypt, session management, dan proteksi CSRF

### Standar Keamanan yang Diterapkan

- ✅ **Query Builder** ketat — tidak ada raw SQL (cegah SQL Injection)
- ✅ **bcrypt** (cost factor 12) — bukan MD5 atau SHA1
- ✅ **CSRF Token** di setiap form
- ✅ **Session Regeneration** setelah login (cegah Session Fixation)
- ✅ **AuthFilter** — middleware proteksi halaman yang memerlukan login

---

## 🗂️ Struktur Folder

```
backend-php/
├── app/
│   ├── Controllers/
│   │   ├── Auth.php              ← Login, logout, session management
│   │   └── Product.php           ← CRUD produk (Skinny Controller)
│   ├── Models/
│   │   ├── UserModel.php         ← Auth logic, password_hash/verify
│   │   └── ProductModel.php      ← CRUD logic, validasi (Fat Model)
│   ├── Views/
│   │   ├── auth/
│   │   │   └── login.php         ← Halaman form login
│   │   └── product/
│   │       ├── index.php         ← Daftar semua produk
│   │       ├── create.php        ← Form tambah produk
│   │       └── edit.php          ← Form edit produk
│   ├── Filters/
│   │   └── AuthFilter.php        ← Middleware: cek status login
│   ├── Database/
│   │   ├── Migrations/
│   │   │   ├── CreateUsersTable.php
│   │   │   └── CreateProductsTable.php
│   │   └── Seeds/
│   │       └── UserSeeder.php    ← Buat user admin default
│   └── Config/
│       ├── Filters.php           ← Daftarkan & terapkan AuthFilter
│       └── Routes.php            ← Definisi URL
├── public/                       ← Document root web server
│   └── index.php
├── .env.example                  ← Template konfigurasi
├── composer.json
└── README.md
```

---

## 🚀 Cara Menjalankan

### Prasyarat

| Software | Versi Minimum | Cek Instalasi        |
| -------- | ------------- | -------------------- |
| PHP      | 8.1+          | `php --version`      |
| Composer | 2.x           | `composer --version` |
| MySQL    | 8.0+          | `mysql --version`    |

---

### Langkah 1 — Install Dependencies

```bash
cd backend-php
composer install
```

---

### Langkah 2 — Konfigurasi Environment

```bash
# Salin file konfigurasi template
cp .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

```env
# ===============================================================
# Ganti CI_ENVIRONMENT ke 'production' saat deploy ke server
# ===============================================================
CI_ENVIRONMENT = development

# ===============================================================
# Database
# ===============================================================
database.default.hostname = localhost
database.default.database = db_btn_test
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

---

### Langkah 3 — Buat Database

Buka MySQL client dan jalankan:

```sql
CREATE DATABASE btn_techtest CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Langkah 4 — Jalankan Migrasi Database

```bash
# Buat tabel users dan products
php spark migrate
```

Output yang diharapkan:

```
Running (default):
  2024-01-01-000001_CreateUsersTable
  2024-01-01-000002_CreateProductsTable
All migrations completed successfully.
```

---

### Langkah 5 — Jalankan Seeder (Buat User Admin Default)

```bash
php spark db:seed UserSeeder
```

Perintah ini membuat satu akun admin dengan kredensial:

- **Username:** `admin`
- **Password:** `Admin@1234`

> ⚠️ **Catatan Keamanan:** Ganti password ini segera setelah pertama kali login di lingkungan production.

---

### Langkah 6 — Jalankan Development Server

```bash
php spark serve
```

Buka browser dan akses: **http://localhost:8080**

---

## 🧪 Panduan Testing Manual

### Akun Login Default

| Field    | Value        |
| -------- | ------------ |
| Username | `admin`      |
| Password | `Admin@1234` |

---

### SKENARIO A — Alur Login & Logout

#### Test A1 — Login berhasil ✅

```
Langkah:
1. Buka http://localhost:8080/login
2. Masukkan Username: admin, Password: Admin@1234
3. Klik tombol Login

Hasil yang diharapkan:
→ Redirect ke halaman dashboard/produk
→ Muncul pesan: "Selamat datang, admin!"
→ Tidak ada error
```

#### Test A2 — Login dengan password salah ✅

```
Langkah:
1. Masukkan Username: admin, Password: salahpassword
2. Klik tombol Login

Hasil yang diharapkan:
→ Tetap di halaman login
→ Muncul pesan: "Username atau password tidak valid."
→ TIDAK menyebutkan apakah username atau password yang salah
  (mencegah user enumeration attack)
```

#### Test A3 — Akses halaman produk tanpa login ✅

```
Langkah:
1. Tanpa login, buka langsung: http://localhost:8080/product

Hasil yang diharapkan:
→ Redirect ke http://localhost:8080/login
→ Muncul pesan: "Silakan login terlebih dahulu."
```

#### Test A4 — Logout ✅

```
Langkah:
1. Setelah login, klik tombol Logout

Hasil yang diharapkan:
→ Session dihancurkan seluruhnya (bukan hanya unset)
→ Redirect ke halaman login
→ Mencoba akses /product kembali → redirect ke login
```

---

### SKENARIO B — CRUD Produk

#### Test B1 — Lihat Daftar Produk ✅

```
Langkah:
1. Login sebagai admin
2. Buka http://localhost:8080/product

Hasil yang diharapkan:
→ Tampil tabel berisi semua produk
→ Ada tombol Tambah, Edit, Hapus untuk setiap produk
```

#### Test B2 — Tambah Produk Baru ✅

```
Langkah:
1. Klik tombol "Tambah Produk"
2. Isi form:
   - Name: Monitor Gaming
   - Price: 350.00
3. Klik Simpan

Hasil yang diharapkan:
→ Redirect ke halaman daftar produk
→ Produk "Monitor Gaming" muncul di tabel
→ Muncul pesan sukses
```

#### Test B3 — Tambah Produk dengan data kosong → Validasi ✅

```
Langkah:
1. Buka form tambah produk
2. Biarkan semua field kosong
3. Klik Simpan

Hasil yang diharapkan:
→ Tetap di halaman form
→ Muncul pesan validasi:
  - "Nama produk wajib diisi."
  - "Harga produk wajib diisi."
```

#### Test B4 — Edit Produk ✅

```
Langkah:
1. Klik tombol Edit pada salah satu produk
2. Ubah harga produk
3. Klik Simpan

Hasil yang diharapkan:
→ Data produk terupdate di database
→ Muncul pesan: "Produk berhasil diperbarui."
```

#### Test B5 — Hapus Produk ✅

```
Langkah:
1. Klik tombol Hapus pada salah satu produk

Hasil yang diharapkan:
→ Produk terhapus dari database
→ Muncul pesan: "Produk berhasil dihapus."
→ Produk tidak muncul lagi di daftar
```

---

### SKENARIO C — Verifikasi Keamanan

#### Test C1 — Verifikasi CSRF Protection ✅

```
Langkah:
1. Buka Developer Tools browser (F12)
2. Lihat source HTML form login atau form produk

Hasil yang diharapkan:
→ Ada hidden input dengan name="csrf_token" atau sejenisnya
→ Value token berubah setiap kali halaman di-refresh
```

#### Test C2 — Verifikasi Password Hash di Database ✅

```bash
# Buka MySQL client
mysql -u root -p btn_techtest

# Lihat data user
SELECT id, username, password_hash FROM users;
```

**Hasil yang diharapkan:**

```
Kolom password_hash berisi string yang diawali "$2y$12$..."
(ini adalah format bcrypt dengan cost factor 12)
BUKAN format MD5 (32 karakter hex) atau SHA1 (40 karakter hex)
```

---

## 🔧 Perintah Spark yang Berguna

```bash
# Lihat semua route yang terdaftar
php spark routes

# Rollback migrasi (hati-hati: menghapus tabel!)
php spark migrate:rollback

# Buat migration baru
php spark make:migration NamaMigration

# Refresh semua migrasi (HAPUS SEMUA DATA!)
php spark migrate:refresh
```

---

## 🗄️ Skema Database

### Tabel `users`

```sql
CREATE TABLE users (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username     VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at   DATETIME,
    updated_at   DATETIME
);
```

### Tabel `products`

```sql
CREATE TABLE products (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(255) NOT NULL,
    price      DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
    created_at DATETIME,
    updated_at DATETIME
);
```

---

## 📦 Dependency

| Package                | Versi | Fungsi        |
| ---------------------- | ----- | ------------- |
| codeigniter4/framework | ^4.5  | PHP Framework |
| PHP                    | ^8.1  | Runtime       |

---

## 🔐 Catatan Keamanan Penting

### Mengapa `bcrypt` dan bukan MD5?

MD5 dan SHA1 adalah algoritma **hashing cepat** — GPU modern bisa mencoba miliaran kombinasi per detik. bcrypt dirancang secara sengaja untuk **lambat** (cost factor mengatur tingkat kelambatannya) dan menghasilkan salt otomatis, sehingga serangan brute-force dan rainbow table tidak praktis secara komputasi.

### Mengapa pesan error login dibuat generik?

Pesan "Username atau password tidak valid" yang generik mencegah **user enumeration attack** — yaitu teknik attacker untuk mengetahui username mana saja yang terdaftar di sistem dengan mencoba satu per satu dan melihat perbedaan pesan error.

### Konfigurasi Security Headers (Untuk Production)

Tambahkan di konfigurasi Nginx atau Apache:

```nginx
add_header X-Frame-Options "DENY";
add_header X-Content-Type-Options "nosniff";
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
add_header Content-Security-Policy "default-src 'self'";
```
