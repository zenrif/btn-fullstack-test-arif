<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div style="max-width:420px; margin: 3rem auto;">
    <div style="text-align:center; margin-bottom:2rem;">
        <div style="font-size:2.5rem; margin-bottom:.5rem;">🏦</div>
        <h1 style="font-size:1.5rem; font-weight:700; color:var(--primary);">BTN Technical Test</h1>
        <p style="color:var(--text-muted); font-size:.9rem; margin-top:.25rem;">Masuk ke sistem</p>
    </div>

    <div class="card">
        <div class="card__body">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?php
            /**
             * KEAMANAN: csrf_field() menghasilkan hidden input berisi token CSRF.
             * Setiap request POST yang tidak membawa token valid akan ditolak framework.
             * Ini mencegah serangan Cross-Site Request Forgery (CSRF).
             */
            ?>
            <form action="<?= base_url('login') ?>" method="POST" novalidate>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        value="<?= esc(old('username')) ?>"
                        autocomplete="username"
                        required
                        placeholder="Masukkan username">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        autocomplete="current-password"
                        required
                        placeholder="Masukkan password">
                </div>

                <button type="submit" class="btn btn--primary" style="width:100%; justify-content:center; padding:.75rem;">
                    Masuk
                </button>
            </form>

        </div>
    </div>

    <p style="text-align:center; margin-top:1rem; font-size:.8rem; color:var(--text-muted);">
        Default: <code>admin</code> / <code>Admin@1234</code>
    </p>
</div>

<?= $this->endSection() ?>