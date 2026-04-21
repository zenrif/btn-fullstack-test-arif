import { useState, useMemo } from "react";

export function useProductSearch(products) {
    const [searchQuery, setSearchQuery] = useState("");

    const filteredProducts = useMemo(() => {
        const trimmedQuery = searchQuery.trim().toLowerCase();

        if (!trimmedQuery) return products;

        return products.filter(({ name }) =>
        name.toLowerCase().includes(trimmedQuery),
        );
    }, [searchQuery, products]);

    return { searchQuery, setSearchQuery, filteredProducts };
}
