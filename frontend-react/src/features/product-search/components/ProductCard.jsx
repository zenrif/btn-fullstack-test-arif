import React from "react";

const formatPrice = (price) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 0,
    }).format(price);

export function ProductCard({ name, price }) {
    return (
        <article className="product-card">
        <h3 className="product-card__name">{name}</h3>

        <p className="product-card__price">
            <span className="sr-only">Harga:</span>

            {formatPrice(price)}
        </p>
        </article>
    );
}
