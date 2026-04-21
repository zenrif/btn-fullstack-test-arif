// src/features/product-search/hooks/useProductSearch.js
// Custom hook: memisahkan logika bisnis dari tampilan (UI)
// Ini memudahkan unit testing — kita bisa test hook ini tanpa render DOM sama sekali.

import { useState, useMemo } from "react";

/**
 * Custom hook untuk logika pencarian produk.
 * Keputusan arsitektural:
 * - Tidak menggunakan useEffect untuk filtering karena filtering adalah
 *   operasi SINKRON MURNI (derived state). useEffect diperuntukkan
 *   untuk side effects (API call, subscriptions, DOM manipulation).
 *   Menggunakan useEffect di sini justru menambah satu siklus render
 *   ekstra yang tidak perlu.
 * - useMemo dipilih karena filteredProducts adalah "computed/derived value"
 *   dari searchQuery dan products — bukan sebuah state mandiri.
 */
export function useProductSearch(products) {
  const [searchQuery, setSearchQuery] = useState("");

  const filteredProducts = useMemo(() => {
    const trimmedQuery = searchQuery.trim().toLowerCase();

    // Guard clause: jika query kosong, kembalikan semua produk
    // tanpa menjalankan operasi filter sama sekali.
    if (!trimmedQuery) return products;

    return products.filter(({ name }) =>
      name.toLowerCase().includes(trimmedQuery)
    );
  }, [searchQuery, products]);

  return { searchQuery, setSearchQuery, filteredProducts };
}