# ⚙️ Backend Node.js — REST API CRUD Produk

> **Soal 2** dari Technical Test BTN Fullstack Developer

---

## 📋 Tentang Project

REST API untuk operasi CRUD produk, dibangun dengan Express.js menggunakan pola arsitektur **MVC (Model-View-Controller)** yang dimodifikasi menjadi tiga layer terpisah:

- **Routes** → Definisi endpoint URL dan method HTTP
- **Controllers** → Orkestrasi request/response (Skinny Controller)
- **Models** → Logika bisnis dan manipulasi data (Fat Model)

---

## 🗂️ Struktur Folder

```
backend-node/
├── src/
│   ├── models/
│   │   └── product.model.js        ← Data & logika bisnis
│   ├── controllers/
│   │   └── product.controller.js   ← Request/response handler
│   ├── routes/
│   │   └── product.routes.js       ← Definisi endpoint
│   └── app.js                      ← Konfigurasi Express
├── server.js                       ← Entry point (booting server)
├── package.json
└── README.md
```

---

## 🚀 Cara Menjalankan

### Prasyarat
- **Node.js** v18 LTS atau lebih baru
- **npm** v9+

### Langkah-langkah

```bash
# 1. Masuk ke direktori project
cd backend-node

# 2. Install semua dependency
npm install

# 3a. Jalankan mode development (auto-restart saat file berubah)
npm run dev

# 3b. Atau jalankan mode production
npm start
```

Server berjalan di: **http://localhost:3000**

---

## 📡 Daftar Endpoint API

Base URL: `http://localhost:3000/api/v1`

| Method | Endpoint | Deskripsi | Status Sukses |
|--------|----------|-----------|---------------|
| `GET` | `/products` | Ambil semua produk | `200 OK` |
| `GET` | `/products/:id` | Ambil produk by ID | `200 OK` |
| `POST` | `/products` | Tambah produk baru | `201 Created` |
| `PUT` | `/products/:id` | Update produk by ID | `200 OK` |
| `DELETE` | `/products/:id` | Hapus produk by ID | `200 OK` |

---

## 🧪 Panduan Testing dengan `curl`

> Alternatif: Import collection ke **Postman** atau **Insomnia**

### Test 1 — GET semua produk ✅
```bash
curl -X GET http://localhost:3000/api/v1/products
```
**Hasil yang diharapkan:**
```json
{
  "success": true,
  "data": [
    { "id": 1, "name": "Laptop", "price": 1200 },
    { "id": 2, "name": "Smartphone", "price": 800 },
    { "id": 3, "name": "Tablet", "price": 600 }
  ]
}
```

---

### Test 2 — GET produk by ID ✅
```bash
curl -X GET http://localhost:3000/api/v1/products/1
```
**Hasil yang diharapkan:**
```json
{
  "success": true,
  "data": { "id": 1, "name": "Laptop", "price": 1200 }
}
```

---

### Test 3 — GET produk ID tidak ada → 404 ✅
```bash
curl -X GET http://localhost:3000/api/v1/products/999
```
**Hasil yang diharapkan:**
```json
{
  "success": false,
  "message": "Produk dengan ID 999 tidak ditemukan."
}
```
**HTTP Status:** `404 Not Found`

---

### Test 4 — POST tambah produk baru ✅
```bash
curl -X POST http://localhost:3000/api/v1/products \
  -H "Content-Type: application/json" \
  -d '{"name": "Headphone", "price": 250}'
```
**Hasil yang diharapkan:**
```json
{
  "success": true,
  "data": { "id": 4, "name": "Headphone", "price": 250 }
}
```
**HTTP Status:** `201 Created`

---

### Test 5 — POST dengan data tidak valid → 400 ✅
```bash
curl -X POST http://localhost:3000/api/v1/products \
  -H "Content-Type: application/json" \
  -d '{"name": "", "price": -100}'
```
**Hasil yang diharapkan:**
```json
{
  "success": false,
  "message": "Field 'name' wajib diisi dan harus berupa string."
}
```
**HTTP Status:** `400 Bad Request`

---

### Test 6 — PUT update produk ✅
```bash
curl -X PUT http://localhost:3000/api/v1/products/1 \
  -H "Content-Type: application/json" \
  -d '{"name": "Laptop Pro", "price": 1500}'
```
**Hasil yang diharapkan:**
```json
{
  "success": true,
  "data": { "id": 1, "name": "Laptop Pro", "price": 1500 }
}
```

---

### Test 7 — DELETE produk ✅
```bash
curl -X DELETE http://localhost:3000/api/v1/products/3
```
**Hasil yang diharapkan:**
```json
{
  "success": true,
  "message": "Produk dengan ID 3 berhasil dihapus."
}
```

---

### Test 8 — DELETE produk yang sudah dihapus → 404 ✅
```bash
curl -X DELETE http://localhost:3000/api/v1/products/3
```
**Hasil yang diharapkan:**
```json
{
  "success": false,
  "message": "Produk dengan ID 3 tidak ditemukan."
}
```

---

### Test 9 — Endpoint tidak dikenal → 404 ✅
```bash
curl -X GET http://localhost:3000/api/v1/unknown-route
```
**Hasil yang diharapkan:**
```json
{
  "success": false,
  "message": "Endpoint tidak ditemukan."
}
```

---

## 📊 Tabel HTTP Status Codes

| Kode | Nama | Kapan Digunakan |
|------|------|----------------|
| `200` | OK | Request berhasil, data dikembalikan |
| `201` | Created | Resource baru berhasil dibuat (POST) |
| `400` | Bad Request | Input dari client salah/tidak lengkap |
| `404` | Not Found | Resource yang diminta tidak ada |
| `500` | Internal Server Error | Kesalahan tak terduga di server |

---

## 📦 Dependency

| Package | Versi | Fungsi |
|---------|-------|--------|
| express | ^4.x | Web framework |
| nodemon | ^3.x | Auto-restart saat development (devDependency) |

---

## 🔑 Keputusan Arsitektural

**Mengapa struktur MVC dan bukan satu file?**

Menaruh semua kode di `server.js` adalah praktik yang tidak skalabel:
- Saat tim bertambah, satu file besar menjadi sumber konflik Git terus-menerus
- Tidak bisa diuji unit per-layer secara independen
- Menukar data source (dari array ke MySQL) membutuhkan perubahan besar

Dengan struktur berlapis, menukar dari in-memory array ke database MySQL **hanya memerlukan perubahan di `product.model.js`** — controller dan routes tidak perlu disentuh.

**Mengapa prefix `/api/v1/`?**

Standar industri untuk backward compatibility. Ketika ada breaking changes di masa depan, kita cukup membuat `/api/v2/` tanpa memutus klien yang masih menggunakan `/api/v1/`.
