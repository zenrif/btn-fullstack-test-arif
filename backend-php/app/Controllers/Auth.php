<?php
// app/Controllers/Auth.php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function loginForm(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        // Redirect jika sudah login — cegah akses halaman login yang tidak perlu
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login', ['title' => 'Login']);
    }

    public function loginProcess(): \CodeIgniter\HTTP\RedirectResponse
    {
        // Rate limiting di level Controller — cegah brute-force attack
        // Di produksi: gunakan middleware throttle atau library seperti
        // CodeIgniter Shield yang sudah memiliki built-in rate limiting.

        $username      = $this->request->getPost('username');
        $plainPassword = $this->request->getPost('password');

        // Validasi input dasar
        if (empty($username) || empty($plainPassword)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi.');
        }

        $user = $this->userModel->attemptLogin($username, $plainPassword);

        if (!$user) {
            // PENTING: pesan error SENGAJA dibuat generik.
            // Jangan pernah tulis "Password salah" atau "Username tidak ditemukan"
            // secara terpisah — itu membantu attacker melakukan user enumeration.
            return redirect()->back()->with('error', 'Username atau password tidak valid.');
        }

        // Login berhasil: regenerate session ID untuk mencegah Session Fixation Attack
        // Session fixation: attacker menanamkan session ID ke korban sebelum login.
        // Setelah regenerate, session ID lama tidak valid lagi.
        session()->regenerate(true); // true = hapus session lama

        // Simpan data minimal ke session — JANGAN simpan password atau data sensitif
        session()->set([
            'user_id'       => $user->id,
            'username'      => $user->username,
            'is_logged_in'  => true,
        ]);

        return redirect()->to('/dashboard')->with('success', "Selamat datang, {$user->username}!");
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        // Hancurkan seluruh session, bukan hanya unset satu key
        // Ini memastikan tidak ada data session yang tersisa
        session()->destroy();

        return redirect()->to('/auth/login')->with('success', 'Anda telah berhasil logout.');
    }
}
