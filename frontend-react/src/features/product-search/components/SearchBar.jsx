// src/features/product-search/components/SearchBar.jsx
// Komponen ini hanya bertanggung jawab atas INPUT — tidak tahu soal produk.

import React from "react";

/**
 * Komponen presentasional (dumb component).
 * Menerima value dan onChange dari parent, tidak menyimpan state sendiri.
 * Keuntungan: bisa dipakai ulang di konteks pencarian lain mana saja.
 */
export function SearchBar({ value, onChange }) {
  return (
    <search role="search" aria-label="Pencarian Produk">
      <label htmlFor="product-search" className="search__label">
        Cari Produk
      </label>
      <input
        id="product-search"
        type="search"
        value={value}
        onChange={(e) => onChange(e.target.value)}
        placeholder="Ketik nama produk..."
        autoComplete="off"
        aria-controls="product-list"
        className="search__input"
      />
    </search>
  );
}