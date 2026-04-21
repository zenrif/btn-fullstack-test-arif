<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'BTN App') ?> — BTN Technical Test</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #1e40af;
            --primary-light: #dbeafe;
            --primary-dark: #1e3a8a;
            --danger: #dc2626;
            --danger-light: #fee2e2;
            --success: #16a34a;
            --success-light: #dcfce7;
            --warning: #d97706;
            --warning-light: #fef3c7;
            --bg: #f1f5f9;
            --surface: #ffffff;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, .08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, .1);
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* NAV */
        .navbar {
            background: var(--primary);
            color: white;
            padding: .875rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(30, 64, 175, .3);
        }

        .navbar__brand {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -.01em;
        }

        .navbar__brand span {
            opacity: .7;
            font-weight: 400;
        }

        .navbar__actions {
            display: flex;
            gap: .75rem;
            align-items: center;
        }

        .navbar__user {
            font-size: .875rem;
            opacity: .85;
        }

        /* LAYOUT */
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ALERTS */
        .alert {
            padding: .875rem 1.125rem;
            border-radius: var(--radius);
            margin-bottom: 1.25rem;
            font-size: .9rem;
            border-left: 4px solid transparent;
        }

        .alert--success {
            background: var(--success-light);
            color: #14532d;
            border-color: var(--success);
        }

        .alert--error {
            background: var(--danger-light);
            color: #7f1d1d;
            border-color: var(--danger);
        }

        .alert--warning {
            background: var(--warning-light);
            color: #78350f;
            border-color: var(--warning);
        }

        /* CARD */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .card__header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card__title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card__body {
            padding: 1.5rem;
        }

        /* TABLE */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9rem;
        }

        .table th {
            padding: .75rem 1rem;
            text-align: left;
            background: var(--bg);
            color: var(--text-muted);
            font-weight: 600;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 2px solid var(--border);
        }

        .table td {
            padding: .875rem 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background: var(--bg);
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .375rem;
            padding: .5rem 1rem;
            border: none;
            border-radius: var(--radius);
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s, transform .1s;
        }

        .btn:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn--primary {
            background: var(--primary);
            color: white;
        }

        .btn--danger {
            background: var(--danger);
            color: white;
        }

        .btn--outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn--sm {
            padding: .375rem .75rem;
            font-size: .8rem;
        }

        /* FORMS */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: .4rem;
        }

        .form-control {
            width: 100%;
            padding: .625rem .875rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-size: .95rem;
            color: var(--text);
            background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .form-error {
            font-size: .8rem;
            color: var(--danger);
            margin-top: .3rem;
        }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: .2rem .6rem;
            border-radius: 9999px;
            font-size: .75rem;
            font-weight: 600;
        }

        .badge--blue {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state__icon {
            font-size: 2.5rem;
            margin-bottom: .75rem;
        }
    </style>
</head>

<body>

    <?php if (session()->get('is_logged_in')): ?>
        <nav class="navbar">
            <div class="navbar__brand">🏦 BTN App <span>/ Technical Test</span></div>
            <div class="navbar__actions">
                <span class="navbar__user">👤 <?= esc(session()->get('username')) ?></span>
                <a href="<?= base_url('product') ?>" class="btn btn--outline btn--sm" style="color:white;border-color:rgba(255,255,255,.4)">Produk</a>
                <a href="<?= base_url('logout') ?>" class="btn btn--sm" style="background:rgba(255,255,255,.15);color:white;">Logout</a>
            </div>
        </nav>
    <?php endif; ?>

    <main class="container">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>

    </main>

</body>

</html>