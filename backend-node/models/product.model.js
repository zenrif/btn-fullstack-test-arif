let products = [
    { id: 1, name: "Laptop", price: 1200 },
    { id: 2, name: "Smartphone", price: 800 },
    { id: 3, name: "Tablet", price: 600 },
];

let nextId = 4;

const ProductModel = {
    findAll() {
        return products;
    },

    findById(id) {
        return products.find((p) => p.id === id) ?? null;
    },

    create({ name, price }) {
        const newProduct = { id: nextId++, name, price };
        products.push(newProduct);
        return newProduct;
    },

    update(id, { name, price }) {
        const index = products.findIndex((p) => p.id === id);
        if (index === -1) return null;
        products[index] = { ...products[index], name, price };
        return products[index];
    },

    delete(id) {
        const index = products.findIndex((p) => p.id === id);
        if (index === -1) return false;
        products.splice(index, 1);
        return true;
    },

};

export default ProductModel;