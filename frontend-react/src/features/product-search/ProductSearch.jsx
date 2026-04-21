// src/features/product-search/ProductSearch.jsx
// Komponen Orkestrator (Container Component) — menyatukan semua bagian.
// Komponen inilah yang "tahu" tentang data dan logika, lalu mendistribusikan
// ke komponen-komponen presentasional di bawahnya.

import React from "react";
import { useProductSearch } from "./hooks/useProductSearch";
import { SearchBar } from "./components/SearchBar";
import { ProductList } from "./components/ProductList";

const PRODUCTS = [
  { name: "Laptop", price: 1200 },
  { name: "Smartphone", price: 800 },
  { name: "Tablet", price: 600 },
];

export function ProductSearch() {
  const { searchQuery, setSearchQuery, filteredProducts } =
    useProductSearch(PRODUCTS);

  return (
    <main className="product-search">
      <header>
        <h1>Katalog Produk</h1>
      </header>

      <SearchBar value={searchQuery} onChange={setSearchQuery} />

      {/* aria-live="polite" memberi tahu screen reader bahwa konten ini
          akan berubah secara dinamis — standar aksesibilitas WCAG 2.1 */}
      <section aria-live="polite" aria-atomic="false">
        <p className="sr-only">
          {filteredProducts.length} produk ditemukan
        </p>
        <ProductList
          products={filteredProducts}
          searchQuery={searchQuery}
        />
      </section>
    </main>
  );
}