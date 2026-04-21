# 🔍 Frontend React — Komponen Pencarian Produk

> **Soal 1** dari Technical Test BTN Fullstack Developer

---

## 📋 Tentang Project

Komponen pencarian produk yang dibangun menggunakan ReactJS dengan prinsip:
- **Separation of Concerns** — komponen dipecah menjadi unit kecil dengan tanggung jawab tunggal
- **Custom Hook** (`useProductSearch`) — logika bisnis dipisah dari tampilan
- **`useMemo`** — filtering dioptimasi, tidak dijalankan ulang jika tidak ada perubahan
- **Semantic HTML + ARIA** — memenuhi standar aksesibilitas WCAG 2.1

---

## 🗂️ Struktur Folder

```
frontend-react/
├── src/
│   ├── features/
│   │   └── product-search/
│   │       ├── components/
│   │       │   ├── SearchBar.jsx       ← Input pencarian (dumb component)
│   │       │   ├── ProductCard.jsx     ← Tampilan satu produk
│   │       │   └── ProductList.jsx     ← List hasil pencarian + empty state
│   │       ├── hooks/
│   │       │   └── useProductSearch.js ← Custom hook: logika filter + state
│   │       └── ProductSearch.jsx       ← Container/orkestrator utama
│   ├── App.jsx                         ← Entry point aplikasi
│   └── main.jsx                        ← ReactDOM render
├── index.html
├── vite.config.js
├── package.json
└── README.md
```

---

## 🚀 Cara Menjalankan

### Prasyarat
- **Node.js** v18 LTS atau lebih baru → [Download](https://nodejs.org)
- **npm** v9+ (sudah termasuk dalam instalasi Node.js)

### Langkah-langkah

```bash
# 1. Masuk ke direktori project
cd frontend-react

# 2. Install semua dependency
npm install

# 3. Jalankan development server
npm run dev
```

Buka browser dan akses: **http://localhost:5173**

### Script Lain

```bash
# Build untuk production
npm run build

# Preview hasil build production
npm run preview

# Jalankan linter
npm run lint
```

---

## 🧪 Panduan Testing Manual

### Test Case 1 — Pencarian Normal ✅
```
Langkah:
1. Buka http://localhost:5173
2. Ketik "lap" di kotak pencarian

Hasil yang diharapkan:
→ Hanya "Laptop" yang muncul di hasil
→ Produk lain (Smartphone, Tablet) menghilang secara real-time
→ Tidak ada tombol "Search" yang perlu diklik
```

### Test Case 2 — Pencarian Tidak Sensitif Huruf (Case-Insensitive) ✅
```
Langkah:
1. Ketik "LAPTOP" (huruf besar)

Hasil yang diharapkan:
→ "Laptop" tetap muncul di hasil
→ Filter bekerja tanpa mempermasalahkan huruf besar/kecil
```

### Test Case 3 — Pencarian Tidak Ditemukan ✅
```
Langkah:
1. Ketik "xyz123" (teks yang tidak ada di produk)

Hasil yang diharapkan:
→ Muncul pesan: 'Tidak ada produk yang cocok dengan "xyz123".'
→ List kosong, bukan error atau crash
```

### Test Case 4 — Hapus Kata Kunci Pencarian ✅
```
Langkah:
1. Ketik "lap" → lihat hasil filter
2. Hapus semua teks di kotak pencarian

Hasil yang diharapkan:
→ Semua 3 produk muncul kembali (Laptop, Smartphone, Tablet)
```

### Test Case 5 — Whitespace / Spasi di Awal/Akhir ✅
```
Langkah:
1. Ketik "  Laptop  " (dengan spasi)

Hasil yang diharapkan:
→ "Laptop" tetap ditemukan (query di-trim sebelum digunakan)
```

---

## 🔑 Keputusan Teknis Penting

### Mengapa `useMemo` bukan `useEffect`?

| | `useEffect` | `useMemo` ✅ |
|---|---|---|
| **Tepat untuk** | Side effects (API, DOM, subscriptions) | Computed/derived values |
| **Jumlah render** | +1 render ekstra (set state di dalam effect) | Langsung di render yang sama |
| **Untuk filtering** | Anti-pattern ❌ | Cara yang benar ✅ |

Filtering produk adalah **derived state** — nilainya sepenuhnya dihitung dari `searchQuery` dan `products`. `useMemo` memastikan kalkulasi hanya diulang ketika salah satu dari dua nilai itu berubah.

### Mengapa Custom Hook?

Custom hook `useProductSearch` memisahkan logika dari tampilan. Manfaat:
- **Testability** → bisa diuji tanpa render DOM (unit test murni)
- **Reusability** → bisa dipakai di halaman pencarian lain
- **Readability** → komponen presentasional menjadi bersih dari logika

---

## 📦 Dependency

| Package | Versi | Fungsi |
|---------|-------|--------|
| react | ^18.x | Library UI |
| react-dom | ^18.x | Render ke DOM |
| vite | ^5.x | Build tool + dev server |

> Tidak ada dependency eksternal tambahan — murni React hooks bawaan.
