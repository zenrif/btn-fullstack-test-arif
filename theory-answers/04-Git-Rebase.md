# Soal 4 — Git: Langkah-Langkah Rebase Branch feature-xyz ke Master

## Pemahaman Awal: Merge vs Rebase

Sebelum menjalankan perintah apapun, saya perlu memastikan saya memilih strategi yang tepat. Tim meminta rebase — bukan merge biasa — dan ada alasan teknis yang kuat di baliknya.

Kondisi branch saat ini:

```
                 A - B - C   ← commit saya di feature-xyz
                /
master: 1 - 2 - 3 - 4 - 5 - 6   ← master sudah jauh lebih maju
```

Jika saya pakai `git merge`, akan muncul merge commit ekstra yang membuat riwayat Git bercabang dan sulit dibaca. Dengan `rebase`, commit saya "dipindahkan" ke ujung master sehingga riwayatnya menjadi linear:

```
-- Setelah git merge (riwayat bercabang):
                 A - B - C - M
                /           /
master: 1 - 2 - 3 - 4 - 5 - 6

-- Setelah git rebase (riwayat linear dan bersih):
master: 1 - 2 - 3 - 4 - 5 - 6 - A' - B' - C'
```

Riwayat yang linear membuat `git log`, `git bisect` saat hunting bug, dan code review di Pull Request jauh lebih mudah dibaca oleh seluruh tim.

---

## Langkah-Langkah yang Saya Lakukan

### Langkah 1 — Memastikan Working Directory Bersih

Hal pertama yang saya lakukan adalah memastikan tidak ada perubahan yang belum di-commit, karena rebase yang berjalan di atas working directory kotor bisa menimbulkan masalah yang tidak perlu.

```bash
git status
```

Jika ada pekerjaan yang sedang berlangsung dan belum siap di-commit, saya simpan sementara menggunakan stash:

```bash
git stash push -m "WIP: fitur validasi form login"

# Verifikasi stash berhasil tersimpan:
git stash list
# Output: stash@{0}: On feature-xyz: WIP: fitur validasi form login
```

---

### Langkah 2 — Mengambil Update Terbaru dari Remote

```bash
git fetch origin
```

Saya memilih `git fetch` dan bukan `git pull` secara sengaja. `git pull` adalah shortcut untuk `fetch + merge` — dan saya tidak ingin ada merge commit masuk secara otomatis tanpa saya kendalikan. Dengan `fetch`, saya hanya mengunduh informasi terbaru dari remote tanpa mengubah apapun di branch lokal saya.

Untuk melihat seberapa jauh master sudah berubah sejak saya terakhir sync:

```bash
git log HEAD..origin/master --oneline
```

---

### Langkah 3 — Memastikan Posisi di Branch yang Benar

```bash
git switch feature-xyz

# Verifikasi:
git branch --show-current
# Output: feature-xyz
```

---

### Langkah 4 — Menjalankan Rebase

```bash
git rebase origin/master
```

Saat ini Git akan mengambil commit-commit saya di `feature-xyz`, memindahkannya sementara, memajukan pointer ke ujung `origin/master`, lalu menempel ulang commit saya satu per satu di atasnya.

Jika berjalan lancar:

```
Successfully rebased and updated refs/heads/feature-xyz.
```

---

### Langkah 5 — Menangani Konflik (Jika Ada)

Konflik bisa terjadi ketika saya dan rekan tim mengubah baris yang sama di file yang sama. Ini hal yang normal dalam kolaborasi. Git akan berhenti dan memberi tahu file mana yang perlu diselesaikan:

```
CONFLICT (content): Merge conflict in src/auth/login.js
hint: Resolve all conflicts manually, then run "git rebase --continue".
```

Cara saya menyelesaikannya:

```bash
# Melihat file yang konflik:
git status

# Di dalam file yang konflik, saya akan menemukan marker seperti ini:
#
# <<<<<<< HEAD  ← kode dari origin/master
# const validateEmail = (email) => email.includes('@');
# =======
# const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
# >>>>>>> a1b2c3d  ← kode dari commit saya
#
# Saya hapus ketiga marker dan sisakan kode yang benar,
# bisa pilih salah satu atau menggabungkan keduanya sesuai kebutuhan.

# Tandai file sebagai sudah diselesaikan:
git add src/auth/login.js

# Lanjutkan rebase ke commit berikutnya:
git rebase --continue
```

Jika ada banyak commit di branch saya, proses ini bisa terjadi beberapa kali — satu kali per commit yang konflik. Saya ulangi langkah di atas sampai rebase selesai sepenuhnya.

Jika di tengah proses saya perlu membatalkan seluruhnya:

```bash
git rebase --abort
# Branch kembali persis seperti kondisi sebelum rebase dimulai.
```

---

### Langkah 6 — Push ke Remote

```bash
# Yang saya gunakan:
git push --force-with-lease origin feature-xyz

# Yang TIDAK saya gunakan:
# git push --force origin feature-xyz
```

#### Alasan Saya Menggunakan `--force-with-lease` dan Bukan `--force`

`--force` bekerja secara "buta" — dia akan menimpa remote branch tanpa peduli apakah ada perubahan baru yang sudah di-push rekan lain sejak saya terakhir `fetch`. Contoh skenario berbahayanya:

```
08:00 - Saya: git fetch origin
08:05 - Rekan saya: git push (commit baru ke feature-xyz dari sisinya)
08:10 - Saya: git rebase origin/master
08:15 - Saya: git push --force

Hasil: commit rekan saya yang di-push jam 08:05 hilang selamanya.
```

`--force-with-lease` lebih aman karena dia akan memeriksa terlebih dahulu — apakah state remote sesuai dengan yang saya ketahui saat terakhir `fetch`? Jika ada perubahan baru yang belum saya lihat, push akan ditolak:

```
08:15 - Saya: git push --force-with-lease
Hasil: PUSH DITOLAK.
       "Remote ref has changed. Fetch and rebase again before pushing."

Saya kemudian fetch ulang, melihat commit rekan saya,
dan bisa berkoordinasi sebelum melanjutkan.
```

`--force-with-lease` adalah standar yang seharusnya dipakai di setiap tim yang bekerja secara kolaboratif pada branch yang sama.

---

### Langkah 7 — Mengambil Kembali Stash (Jika Ada)

Jika tadi saya menyimpan pekerjaan yang belum selesai:

```bash
git stash pop
```

---

## Ringkasan Perintah

```bash
git status                                       # 1. Cek working directory
git stash push -m "WIP: ..."                     # 2. Simpan WIP (jika perlu)
git fetch origin                                 # 3. Ambil update remote
git switch feature-xyz                           # 4. Pastikan di branch yang benar
git rebase origin/master                         # 5. Eksekusi rebase

# Jika ada konflik:
git status                                       # 5a. Lihat file yang konflik
# (edit file, hapus conflict markers)
git add <file>                                   # 5b. Tandai resolved
git rebase --continue                            # 5c. Lanjut ke commit berikutnya
# (ulangi 5a-5c jika konflik muncul lagi di commit berikutnya)

git push --force-with-lease origin feature-xyz   # 6. Push dengan aman
git stash pop                                    # 7. Ambil kembali WIP (jika ada)
```
