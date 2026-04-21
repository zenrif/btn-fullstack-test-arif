import React from "react";

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
