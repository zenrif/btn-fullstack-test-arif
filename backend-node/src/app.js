import express from "express";

import productRoutes from "../routes/product.routes.js";

const app = express();

app.use(express.json()); 

app.use("/api/v1/products", productRoutes);

app.use((req, res) => {
    res.status(404).json({ success: false, message: "Endpoint tidak ditemukan." });
});

app.use((err, req, res, next) => {
    console.error(`[ERROR] ${err.stack}`);
    res.status(500).json({ success: false, message: "Terjadi kesalahan pada server." });
});

export default app;