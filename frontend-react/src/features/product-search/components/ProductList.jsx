import React from "react";

import { ProductCard } from "./ProductCard";

export function ProductList({ products, searchQuery }) {
    if (products.length === 0) {
        return (
        <section aria-live="polite" className="product-list--empty">
            <p>
            {searchQuery
                ? `Tidak ada produk yang cocok dengan "${searchQuery}".`
                : "Tidak ada produk tersedia."}
            </p>
        </section>
        );
    }

    return (
        <ul
        id="product-list"
        role="list"
        aria-label="Hasil pencarian produk"
        className="product-list"
        >
        {products.map(({ name, price }) => (
            <li key={name} role="listitem">
            <ProductCard name={name} price={price} />
            </li>
        ))}
        </ul>
    );
}
