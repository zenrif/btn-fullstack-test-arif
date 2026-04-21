-- ============================================================
-- Soal 3 — MySQL: Total Nilai Pesanan Per Pelanggan (2025)
-- BTN Technical Test — Fullstack Developer
-- ============================================================
-- Author  : Fullstack Developer Candidate
-- Desc    : Menghitung total nilai pesanan dan jumlah transaksi
--           per pelanggan khusus tahun 2025, diurutkan dari
--           pelanggan dengan nilai terbesar.
-- ============================================================


-- ============================================================
-- BAGIAN 1: QUERY UTAMA
-- ============================================================

SELECT
    o.customer_id,
    SUM(o.total_price)  AS total_nilai_pesanan,
    COUNT(o.order_id)   AS jumlah_transaksi
FROM
    orders AS o
WHERE
    -- ❌ Anti-pattern yang sering ditemui:
    --    WHERE YEAR(created_at) = 2025
    --
    --    Membungkus kolom di dalam fungsi akan menonaktifkan index.
    --    MySQL terpaksa evaluasi YEAR() untuk SETIAP baris → full table scan.
    --    Di tabel 100 juta baris, ini bisa makan waktu menit.
    --
    -- ✅ Gunakan range eksplisit agar index tetap bekerja (sargable query):
    o.created_at BETWEEN '2025-01-01 00:00:00' AND '2025-12-31 23:59:59'
GROUP BY
    o.customer_id
ORDER BY
    total_nilai_pesanan DESC;

-- Expected output (berdasarkan data sample di Bagian 4):
-- +--------------+---------------------+------------------+
-- | customer_id  | total_nilai_pesanan | jumlah_transaksi |
-- +--------------+---------------------+------------------+
-- | 101          | 2230000.00          | 3                |
-- | 102          | 1650000.00          | 2                |
-- | 103          | 300000.00           | 1                |
-- +--------------+---------------------+------------------+


-- ============================================================
-- BAGIAN 2: STRATEGI INDEXING UNTUK SKALA PERBANKAN
-- ============================================================
-- Di environment perbankan, tabel orders bisa hidup di angka
-- ratusan juta baris. Query tanpa index yang tepat akan
-- melakukan FULL TABLE SCAN — baca setiap baris satu-satu.
-- ============================================================

-- ------------------------------------------------------------
-- Index 1: Composite Index
-- ------------------------------------------------------------
-- Urutan kolom di sini bukan kebetulan.
-- created_at di depan karena dia yang jadi filter WHERE (range scan).
-- customer_id di belakang untuk support GROUP BY.
-- Satu index ini sudah cukup handle keduanya sekaligus.
-- ------------------------------------------------------------
CREATE INDEX idx_orders_date_customer
    ON orders (created_at, customer_id);


-- ------------------------------------------------------------
-- Index 2: Covering Index — Level Optimal
-- ------------------------------------------------------------
-- Tambahkan total_price ke dalam index.
-- MySQL tidak perlu balik ke tabel utama sama sekali —
-- semua kolom yang dibutuhkan query sudah ada di index.
-- Ini yang disebut "index-only scan" atau "covering index".
-- ------------------------------------------------------------
CREATE INDEX idx_orders_covering
    ON orders (created_at, customer_id, total_price);


-- ============================================================
-- BAGIAN 3: VERIFIKASI — EXPLAIN PLAN
-- ============================================================
-- Selalu jalankan EXPLAIN sebelum deploy ke production
-- untuk memastikan optimizer benar-benar pakai index kita.
-- ============================================================

EXPLAIN SELECT
    o.customer_id,
    SUM(o.total_price)  AS total_nilai_pesanan,
    COUNT(o.order_id)   AS jumlah_transaksi
FROM
    orders AS o
WHERE
    o.created_at BETWEEN '2025-01-01 00:00:00' AND '2025-12-31 23:59:59'
GROUP BY
    o.customer_id
ORDER BY
    total_nilai_pesanan DESC;

-- Kolom kritis yang harus diperhatikan dari output EXPLAIN:
--
-- | Kolom  | Nilai yang Diharapkan   | Nilai Buruk (Red Flag!)  |
-- |--------|-------------------------|--------------------------|
-- | type   | range, ref, index       | ALL  ← full table scan!  |
-- | key    | nama index kita         | NULL ← index tidak pakai |
-- | rows   | angka kecil             | angka sangat besar       |
-- | Extra  | Using index             | Using filesort           |


-- ============================================================
-- BAGIAN 4: SETUP TABEL + DATA SAMPLE (untuk testing lokal)
-- ============================================================

CREATE TABLE IF NOT EXISTS orders (
    order_id    INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED    NOT NULL,
    total_price DECIMAL(15, 2)  NOT NULL DEFAULT 0.00,
    created_at  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    -- Index langsung didefinisikan di DDL agar tidak perlu ALTER TABLE
    -- terpisah saat pertama kali deploy schema.
    INDEX idx_orders_date_customer (created_at, customer_id),
    INDEX idx_orders_covering      (created_at, customer_id, total_price)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- Data sample untuk verifikasi query
INSERT INTO orders (customer_id, total_price, created_at) VALUES
    -- Data tahun 2025 — harus muncul di hasil query
    (101, 500000.00,  '2025-01-15 10:30:00'),
    (102, 1200000.00, '2025-02-20 14:00:00'),
    (101, 750000.00,  '2025-03-10 09:15:00'),
    (103, 300000.00,  '2025-04-05 16:45:00'),
    (102, 450000.00,  '2025-05-22 11:00:00'),
    (101, 980000.00,  '2025-06-30 13:30:00'),

    -- Data di luar 2025 — TIDAK boleh muncul di hasil query
    (101, 999999.00,  '2024-12-31 23:59:00'),  -- tahun 2024
    (102, 999999.00,  '2026-01-01 00:01:00');   -- tahun 2026