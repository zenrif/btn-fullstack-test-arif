# Fullstack Developer — Technical Test

> **Kandidat:** Mohammad Zaenal Arif Santoso
> **Posisi:** Fullstack Developer
> **Stack:** ReactJS · Node.js/Express · CodeIgniter 4 (PHP 8) · MySQL · Git

---

## 📁 Struktur Repositori

```
btn-fullstack-test-arif/
│
├── 📁 frontend-react/      → Soal 1 : ReactJS — Komponen Pencarian Produk
├── 📁 backend-node/        → Soal 2 : Express.js — REST API CRUD Produk
├── 📁 backend-php/         → Soal 6 & 7 : CodeIgniter 4 — CRUD & Auth
├── 📁 theory-answers/      → Soal 3, 4, 5 — SQL · Git Rebase · SDLC
└── README.md               → Dokumen ini
```

---

## 🗺️ Peta Soal & Lokasi Jawaban

| No  | Topik                     | Lokasi                                 | Teknologi               |
| --- | ------------------------- | -------------------------------------- | ----------------------- |
| 1   | Komponen Pencarian Produk | `frontend-react/`                      | ReactJS, Hooks, useMemo |
| 2   | REST API CRUD Produk      | `backend-node/`                        | Express.js, MVC Pattern |
| 3   | Query SQL & Indexing      | `theory-answers/03-Database-Query.sql` | MySQL                   |
| 4   | Git Rebase Workflow       | `theory-answers/04-Git-Rebase.md`      | Git                     |
| 5   | Waterfall vs Agile        | `theory-answers/05-SDLC-Analysis.md`   | SDLC                    |
| 6   | CRUD Produk               | `backend-php/`                         | CodeIgniter 4, PHP 8    |
| 7   | Sistem Login & Auth       | `backend-php/`                         | CodeIgniter 4, bcrypt   |

---

## ⚡ Quick Start — Menjalankan Semua Project

### Prasyarat Global

Pastikan software berikut sudah terinstal di mesin Anda:

| Software | Versi Minimum | Cek Instalasi        |
| -------- | ------------- | -------------------- |
| Node.js  | v18.x LTS     | `node --version`     |
| npm      | v9.x          | `npm --version`      |
| PHP      | v8.1+         | `php --version`      |
| Composer | v2.x          | `composer --version` |
| MySQL    | v8.0+         | `mysql --version`    |

---

### 1️⃣ Frontend React

```bash
cd frontend-react
npm install
npm run dev
# Buka: http://localhost:5173
```

---

### 2️⃣ Backend Node.js

```bash
cd backend-node
npm install
npm run dev
# Buka: http://localhost:3000/api/v1/products
```

---

### 3️⃣ Backend PHP (CodeIgniter 4)

```bash
cd backend-php
composer install
cp .env.example .env
# Edit .env: isi konfigurasi database
php spark migrate
php spark db:seed UserSeeder
php spark serve
# Buka: http://localhost:8080
```

---

## 🧪 Ringkasan Testing

| Project        | Cara Test Cepat                            |
| -------------- | ------------------------------------------ |
| Frontend React | Buka browser → ketik di kotak pencarian    |
| Backend Node   | Gunakan Postman / curl                     |
| Backend PHP    | Buka browser → login → operasi CRUD via UI |

> Detail lengkap testing ada di `README.md` masing-masing subfolder.

---

## 🔐 Prinsip Keamanan yang Diterapkan

- ✅ **SQL Injection** → Query Builder (CodeIgniter) + Parameterized Query
- ✅ **Password Storage** → `password_hash()` bcrypt, cost factor 12 (OWASP)
- ✅ **CSRF Protection** → Token CSRF di setiap form HTML
- ✅ **Session Fixation** → `session()->regenerate(true)` setelah login
- ✅ **HTTP Security Headers** → X-Frame-Options, X-Content-Type-Options, HSTS
- ✅ **Input Validation** → Server-side validation di Model layer
- ✅ **Error Messages** → Pesan generik (tidak bocorkan detail sistem)

---

## 🏗️ Keputusan Arsitektural

### Frontend

- **Custom Hook** (`useProductSearch`) → memisahkan logika dari tampilan, mudah diuji
- **useMemo** untuk filtering → hindari kalkulasi ulang yang tidak perlu
- **Semantic HTML** + ARIA → standar aksesibilitas WCAG 2.1
- **Komponen Granular** → SRP: setiap komponen punya satu tanggung jawab

### Backend Node.js

- **MVC Pattern** → Routes / Controllers / Models dipisah per file
- **API Versioning** (`/api/v1/`) → backward compatibility saat ada breaking changes
- **HTTP Status Codes Standar** → 200, 201, 400, 404, 500
- **Try-Catch di setiap handler** → tidak ada unhandled exception

### Backend PHP

- **Fat Model, Skinny Controller** → logika bisnis di Model, Controller hanya orkestrasi
- **Query Builder ketat** → tidak ada raw SQL di seluruh kodebase
- **bcrypt** → bukan MD5/SHA1, sesuai standar OWASP

---
