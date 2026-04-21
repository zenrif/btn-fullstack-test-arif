<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width:560px; margin:0 auto;">

    <div style="margin-bottom:1.25rem;">
        <a href="<?= base_url('product') ?>" class="btn btn--outline btn--sm">← Kembali</a>
    </div>

    <div class="card">
        <div class="card__header">
            <h2 class="card__title">➕ Tambah Produk Baru</h2>
        </div>
        <div class="card__body">

            <?php if (session()->getFlashdata('errors') || isset($errors)): ?>
                <div class="alert alert--error">
                    <strong>Periksa kembali data Anda:</strong>
                    <ul style="margin:.5rem 0 0 1rem;">
                        <?php
                        $errs = session()->getFlashdata('errors') ?? ($errors ?? []);
                        foreach ((array) $errs as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('product/store') ?>" method="POST" novalidate>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk <span style="color:var(--danger)">*</span></label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?= esc(old('name')) ?>"
                        placeholder="Contoh: Laptop Gaming"
                        required
                        maxlength="255"
                    >
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Harga (USD) <span style="color:var(--danger)">*</span></label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-control"
                        value="<?= esc(old('price')) ?>"
                        placeholder="Contoh: 1200.00"
                        required
                        min="0"
                        step="0.01"
                    >
                </div>

                <div style="display:flex; gap:.75rem; margin-top:1.5rem;">
                    <button type="submit" class="btn btn--primary">💾 Simpan Produk</button>
                    <a href="<?= base_url('product') ?>" class="btn btn--outline">Batal</a>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
