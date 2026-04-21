<?php
// app/Models/ProductModel.php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';

    // Whitelist kolom yang boleh diisi — mencegah Mass Assignment vulnerability
    protected $allowedFields = ['name', 'price'];

    protected $useTimestamps = true; // otomatis isi created_at & updated_at

    // Validasi di level Model — data kotor tidak pernah sampai ke database
    protected $validationRules = [
        'name'  => 'required|min_length[2]|max_length[255]',
        'price' => 'required|decimal|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'name'  => ['required' => 'Nama produk wajib diisi.'],
        'price' => ['required' => 'Harga produk wajib diisi.', 'decimal' => 'Harga harus berupa angka desimal.'],
    ];

    /**
     * Mengambil semua produk, diurutkan dari terbaru.
     * Semua query menggunakan Query Builder — tidak ada raw SQL.
     */
    public function getAllProducts(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Membuat produk baru.
     * Model::insert() otomatis menjalankan validasi sebelum query.
     * Mengembalikan ID baru jika berhasil, false jika gagal.
     */
    public function createProduct(array $data): int|false
    {
        return $this->insert($data, true); // true = return insert ID
    }

    /**
     * Update produk. Mengembalikan true jika berhasil.
     */
    public function updateProduct(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Hapus produk. Mengembalikan true jika berhasil.
     */
    public function deleteProduct(int $id): bool
    {
        return $this->delete($id);
    }
}
