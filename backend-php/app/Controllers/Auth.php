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
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login', ['title' => 'Login']);
    }

    public function loginProcess(): \CodeIgniter\HTTP\RedirectResponse
    {

        $username      = $this->request->getPost('username');
        $plainPassword = $this->request->getPost('password');

        if (empty($username) || empty($plainPassword)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi.');
        }

        $user = $this->userModel->attemptLogin($username, $plainPassword);

        if (!$user) {
            return redirect()->back()->with('error', 'Username atau password tidak valid.');
        }

        session()->regenerate(true);

        session()->set([
            'user_id'       => $user->id,
            'username'      => $user->username,
            'is_logged_in'  => true,
        ]);


        return redirect()->to('/product')->with('success', "Selamat datang, {$user->username}!");
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
