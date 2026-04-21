<?php
// app/Controllers/Product.php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    private ProductModel $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        // Aktifkan CSRF helper jika menggunakan form HTML
        helper(['form', 'url']);
    }

    // READ: Tampilkan semua produk
    public function index(): string
    {
        $data = [
            'title'    => 'Manajemen Produk',
            'products' => $this->productModel->getAllProducts(),
        ];
        return view('product/index', $data);
    }

    // CREATE: Tampilkan form tambah produk
    public function create(): string
    {
        return view('product/create', ['title' => 'Tambah Produk']);
    }

    // STORE: Proses data dari form tambah
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        // CSRF token divalidasi otomatis oleh framework (lihat konfigurasi di bawah)
        $data = [
            'name'  => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
        ];

        if (!$this->productModel->createProduct($data)) {
            // Kembalikan ke form dengan error dari Model
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->productModel->errors());
        }

        return redirect()->to('/product')->with('success', 'Produk berhasil ditambahkan.');
    }

    // EDIT: Tampilkan form edit
    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/product')->with('error', 'Produk tidak ditemukan.');
        }

        return view('product/edit', [
            'title'   => 'Edit Produk',
            'product' => $product,
        ]);
    }

    // UPDATE: Proses data dari form edit
    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $data = [
            'name'  => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
        ];

        if (!$this->productModel->updateProduct($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->productModel->errors());
        }

        return redirect()->to('/product')->with('success', 'Produk berhasil diperbarui.');
    }

    // DELETE: Hapus produk
    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->productModel->deleteProduct($id)) {
            return redirect()->to('/product')->with('error', 'Produk tidak ditemukan.');
        }

        return redirect()->to('/product')->with('success', 'Produk berhasil dihapus.');
    }
}
