# Soal 5 — SDLC: Perbedaan Waterfall dan Agile dalam Pengembangan Perangkat Lunak

Saya akan menjelaskan perbedaan keduanya bukan dari sudut pandang definisi textbook, melainkan dari perspektif bisnis dan manajemen proyek — karena di situlah perbedaan keduanya paling terasa secara nyata.

---

## Waterfall — Metodologi "Cetak Biru"

### Cara Kerjanya

Waterfall berjalan seperti konstruksi gedung: saya tidak bisa pasang atap sebelum dindingnya jadi, dan tidak bisa bangun dinding sebelum pondasinya selesai. Setiap fase harus **selesai dan di-sign-off** sebelum fase berikutnya bisa dimulai.

```
[Requirement] → [Design] → [Development] → [Testing] → [Deployment]
     ↓               ↓            ↓              ↓            ↓
  Sign-off      Sign-off      Sign-off       Sign-off    Go-Live
```

### Kelemahan Utama: Biaya Perubahan yang Eksponensial

Ini adalah kelemahan paling kritis dari Waterfall yang sering tidak disadari klien sampai terlambat. Semakin terlambat sebuah perubahan atau bug ditemukan, semakin mahal biaya yang dibutuhkan untuk memperbaikinya:

```
Biaya menemukan perubahan/bug di fase:

Requirement  : Rp 1 juta    → ubah dokumen, murah dan cepat
Design       : Rp 5 juta    → ubah wireframe + dokumen
Development  : Rp 25 juta   → tulis ulang kode + dokumen
Testing      : Rp 80 juta   → perbaiki kode + uji ulang
Production   : Rp 300 juta  → rollback, hotfix, downtime, risiko reputasi
```

_Angka ilustratif — rasionya dikenal sebagai "Rule of Ten" dalam rekayasa perangkat lunak._

### Time-to-Market: Lambat

Dengan Waterfall, tidak ada satu pun fitur yang bisa digunakan klien sampai proyek 100% selesai. Untuk proyek 12 bulan, artinya klien menunggu 12 bulan penuh — baru kemudian tahu apakah produk yang dibangun sudah sesuai kebutuhan atau tidak.

### Keterlibatan Klien: Tinggi di Awal dan Akhir Saja

```
Klien aktif di:  [Requirement]                              [UAT/Delivery]
                     ████                                        ████
Timeline:    |-------|-------|-------|-------|-------|-------|--------|
           Kick-off Design   Dev    Dev    Dev   Testing    Go-Live
```

Klien menandatangani requirement di bulan pertama, lalu tidak terlibat selama proses development berlangsung, dan muncul kembali di UAT (User Acceptance Testing). Di sinilah sering terjadi momen yang mahal: _"Oh, yang kami maksud bukan begini..."_ — padahal proyek sudah hampir selesai.

### Keunggulan Waterfall

Meskipun memiliki kelemahan di atas, Waterfall tetap relevan dan bahkan lebih unggul dalam konteks tertentu:

1. **Proyek dengan compliance ketat** — Sistem core banking yang harus lolos audit BI atau OJK sebelum go-live. Regulator membutuhkan dokumentasi lengkap dan formal, bukan iterasi.
2. **Scope yang benar-benar beku** — Sistem embedded untuk ATM atau mesin EDC dengan spesifikasi hardware yang sudah fixed.
3. **Kontrak fixed-price, fixed-scope** — Waterfall memberikan kepastian hukum dan finansial ketika klien membayar harga tetap untuk deliverable yang sudah pasti.

---

## Agile — Metodologi "Kapal Speedboat"

### Cara Kerjanya

Agile bukan berarti tanpa rencana. Agile berarti rencana yang **terus diperbarui berdasarkan fakta baru** — bukan dokumen requirement dari 6 bulan lalu yang mungkin sudah tidak relevan.

```
Sprint 1 (2 minggu):  [Plan] → [Build] → [Test] → [Review dengan Klien]
                                                           ↓
                                               Feedback masuk, jadi bahan
                                               perencanaan sprint berikutnya
Sprint 2 (2 minggu):  [Plan] → [Build] → [Test] → [Review dengan Klien]
                                                           ↓
                                               ... dan seterusnya
```

### Keunggulan Utama: Biaya Perubahan yang Konstan

Ini adalah perbedaan paling signifikan dari perspektif bisnis. Di Agile, mengubah arah di sprint ke-8 biayanya sama saja dengan mengubah arah di sprint ke-2. Perubahan adalah bagian dari proses, bukan pengecualian yang mahal.

```
Biaya perubahan di Agile:

Sprint 1  : ~Rp 5 juta  (dimasukkan ke backlog sprint berikutnya)
Sprint 6  : ~Rp 5 juta  (tetap sama)
Sprint 12 : ~Rp 5 juta  (tetap sama)
```

### Time-to-Market: Cepat dan Bertahap

```
Waterfall: satu rilis besar setelah 12 bulan
           [==================================FULL PRODUCT==]
                                               Bulan ke-12 ↑

Agile:     rilis bertahap mulai bulan ke-2
           [Fitur A] [Fitur B] [Fitur C] [Fitur D] [...]
                ↑         ↑         ↑
             Bulan 2   Bulan 4   Bulan 6
```

Dengan Agile, fitur terpenting (MVP) bisa diluncurkan dan mulai menghasilkan value jauh sebelum seluruh proyek selesai. Di industri fintech yang kompetitif, meluncurkan fitur 3 bulan lebih awal dari kompetitor bisa menjadi perbedaan yang signifikan dalam akuisisi pengguna.

### Keterlibatan Klien: Aktif Setiap Sprint

Ini adalah syarat mutlak Agile yang sering gagal dipenuhi. Klien harus hadir di setiap Sprint Review — biasanya setiap 2 minggu. Jika klien tidak mau terlibat secara aktif, tim akan terus membangun berdasarkan asumsi, dan hasilnya tidak akan jauh berbeda dari Waterfall yang buruk.

```
Klien aktif di: [S1][S2][S3][S4][S5][S6][S7][S8][S9][S10]...[Sn]
                 ██  ██  ██  ██  ██  ██  ██  ██  ██  ██        ██
```

### Kelemahan Agile

1. **Prediktabilitas biaya lebih rendah** — Sulit memberikan angka total biaya di awal proyek karena scope bersifat evolusioner.
2. **Rentan scope creep** — Tanpa Product Owner yang disiplin dalam menjaga prioritas backlog, proyek bisa terus melebar tanpa arah yang jelas.

---

## Perbandingan Langsung

| Dimensi                   | Waterfall                                     | Agile                                         |
| ------------------------- | --------------------------------------------- | --------------------------------------------- |
| **Biaya Perubahan**       | Eksponensial — makin terlambat, makin mahal   | Konstan — perubahan adalah bagian dari proses |
| **Time-to-Market**        | Lambat — satu rilis besar di akhir            | Cepat — rilis bertahap, value lebih awal      |
| **Keterlibatan Klien**    | Tinggi di awal & akhir saja                   | Aktif setiap sprint (wajib)                   |
| **Dokumentasi**           | Sangat lengkap & formal                       | Minimalis, fokus pada working software        |
| **Prediktabilitas Biaya** | Tinggi (jika scope tidak berubah)             | Lebih sulit diprediksi di awal                |
| **Risiko Utama**          | Produk jadi tidak relevan saat rilis          | Scope creep tanpa Product Owner yang disiplin |
| **Cocok untuk**           | Compliance ketat, scope beku, kontrak fixed   | Produk digital, scope evolusioner, startup    |
| **Contoh Nyata**          | Sistem core banking, sistem BUMN dengan audit | Super-app, mobile banking, fintech            |

---

## Kesimpulan

Menurut saya, pertanyaan yang tepat bukan _"mana yang lebih baik?"_ melainkan _"apa karakteristik proyek ini, dan metodologi mana yang paling sesuai?"_

Dalam konteks perbankan dan BUMN seperti BTN, saya melihat keduanya bisa relevan tergantung jenis proyeknya. Untuk sistem core banking atau proyek yang melibatkan regulasi OJK/BI, Waterfall lebih tepat karena dokumentasi formal dan prediktabilitas deliverable adalah keharusan. Namun untuk pengembangan produk digital seperti aplikasi mobile banking atau layanan fintech baru, Agile jauh lebih efisien karena kebutuhan pengguna yang terus berkembang membutuhkan kemampuan beradaptasi yang cepat.

Banyak tim engineering modern di perusahaan perbankan justru menggunakan **pendekatan hybrid**: fase requirement dan arsitektur yang terstruktur seperti Waterfall, diikuti development dan delivery yang iteratif seperti Agile — mengambil kelebihan dari kedua metodologi sesuai dengan konteks dan kebutuhan proyeknya.
