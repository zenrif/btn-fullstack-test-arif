<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card__header">
        <h2 class="card__title">📦 Manajemen Produk</h2>
        <a href="<?= base_url('product/create') ?>" class="btn btn--primary">
            + Tambah Produk
        </a>
    </div>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <div class="empty-state__icon">📭</div>
            <p>Belum ada produk. Klik <strong>Tambah Produk</strong> untuk memulai.</p>
        </div>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Ditambahkan</th>
                        <th style="width:160px; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <td><span class="badge badge--blue"><?= $index + 1 ?></span></td>
                        <td style="font-weight:500;"><?= esc($product['name']) ?></td>
                        <td>
                            <strong style="color:var(--primary);">
                                <?= 'Rp ' . number_format((float)$product['price'], 0, ',', '.') ?>
                            </strong>
                        </td>
                        <td style="color:var(--text-muted); font-size:.85rem;">
                            <?= date('d M Y', strtotime($product['created_at'])) ?>
                        </td>
                        <td>
                            <div style="display:flex; gap:.5rem; justify-content:center;">
                                <a href="<?= base_url('product/edit/' . $product['id']) ?>"
                                   class="btn btn--outline btn--sm">
                                    ✏️ Edit
                                </a>

                                <?php
                                /**
                                 * DELETE via form POST karena HTML tidak mendukung method DELETE.
                                 * CSRF token disertakan untuk mencegah CSRF attack.
                                 * JavaScript confirm() sebagai konfirmasi ringan di sisi client
                                 * (bukan pengganti validasi server-side).
                                 */
                                ?>
                                <form action="<?= base_url('product/delete/' . $product['id']) ?>"
                                      method="POST"
                                      onsubmit="return confirm('Hapus produk \'<?= esc($product['name']) ?>\'? Tindakan ini tidak bisa dibatalkan.')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn--danger btn--sm">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="padding:.75rem 1.5rem; border-top:1px solid var(--border); color:var(--text-muted); font-size:.85rem;">
            Total: <strong><?= count($products) ?></strong> produk
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
