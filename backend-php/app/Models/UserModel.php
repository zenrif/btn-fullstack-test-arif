<?php
// app/Models/UserModel.php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // password TIDAK ada di allowedFields agar tidak bisa diset sembarangan
    // dari luar — harus selalu melalui method setPassword()
    protected $allowedFields = ['username', 'password_hash'];
    protected $useTimestamps = true;

    /**
     * Hash password menggunakan bcrypt (PASSWORD_BCRYPT).
     * Cost factor 12 adalah rekomendasi OWASP untuk server modern —
     * cukup lambat untuk menyulitkan brute-force, tapi tidak terlalu
     * lambat untuk user experience.
     *
     * DILARANG MENGGUNAKAN: md5(), sha1(), sha256() untuk password.
     * Alasan: algoritma tersebut terlalu cepat dan tidak memiliki salt bawaan.
     */
    public function hashPassword(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Autentikasi: cari user by username, lalu verifikasi password.
     * password_verify() aman terhadap timing attack karena
     * ia selalu menghabiskan waktu yang kira-kira sama, terlepas dari
     * apakah password benar atau salah.
     *
     * Mengembalikan objek user atau null jika gagal.
     */
    public function attemptLogin(string $username, string $plainPassword): object|null
    {
        $user = $this->where('username', $username)->first();

        if (!$user || !password_verify($plainPassword, $user['password_hash'])) {
            return null; // Pesan error dibuat generik — jangan bocorkan apakah username atau password yang salah
        }

        return (object) $user;
    }

    /**
     * Seeder helper: simpan user baru dengan password yang sudah di-hash.
     */
    public function registerUser(string $username, string $plainPassword): bool
    {
        return $this->insert([
            'username'      => $username,
            'password_hash' => $this->hashPassword($plainPassword),
        ]);
    }
}
