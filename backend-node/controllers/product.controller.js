import ProductModel from "../models/product.model.js";

const ProductController = {
    getAll(req, res) {
        try {
        const products = ProductModel.findAll();
        res.status(200).json({ success: true, data: products });
        } catch (error) {
        res.status(500).json({ success: false, message: "Internal Server Error" });
        }
    },

    getById(req, res) {
        try {
        const id = parseInt(req.params.id, 10);
        const product = ProductModel.findById(id);

        if (!product) {
            return res.status(404).json({ success: false, message: `Produk dengan ID ${id} tidak ditemukan.` });
        }

        res.status(200).json({ success: true, data: product });
        } catch (error) {
        res.status(500).json({ success: false, message: "Internal Server Error" });
        }
    },

    create(req, res) {
        try {
        const { name, price } = req.body;

        if (!name || typeof name !== "string" || name.trim() === "") {
            return res.status(400).json({ success: false, message: "Field 'name' wajib diisi dan harus berupa string." });
        }

        if (price === undefined || typeof price !== "number" || price < 0) {
            return res.status(400).json({ success: false, message: "Field 'price' wajib diisi dan harus berupa angka non-negatif." });
        }

        const newProduct = ProductModel.create({ name: name.trim(), price });
        res.status(201).json({ success: true, data: newProduct });
        } catch (error) {
        res.status(500).json({ success: false, message: "Internal Server Error" });
        }
    },

    update(req, res) {
        try {
        const id = parseInt(req.params.id, 10);
        const { name, price } = req.body;

        if (!name || typeof name !== "string" || name.trim() === "") {
            return res.status(400).json({ success: false, message: "Field 'name' wajib diisi dan harus berupa string." });
        }

        if (price === undefined || typeof price !== "number" || price < 0) {
            return res.status(400).json({ success: false, message: "Field 'price' wajib diisi dan harus berupa angka non-negatif." });
        }

        const updatedProduct = ProductModel.update(id, { name: name.trim(), price });

        if (!updatedProduct) {
            return res.status(404).json({ success: false, message: `Produk dengan ID ${id} tidak ditemukan.` });
        }

        res.status(200).json({ success: true, data: updatedProduct });
        } catch (error) {
        res.status(500).json({ success: false, message: "Internal Server Error" });
        }
    },

    delete(req, res) {
        try {
        const id = parseInt(req.params.id, 10);
        const isDeleted = ProductModel.delete(id);

        if (!isDeleted) {
            return res.status(404).json({ success: false, message: `Produk dengan ID ${id} tidak ditemukan.` });
        }

        res.status(200).json({ success: true, message: `Produk dengan ID ${id} berhasil dihapus.` });
        } catch (error) {
        res.status(500).json({ success: false, message: "Internal Server Error" });
        }
    },
};

export default ProductController;