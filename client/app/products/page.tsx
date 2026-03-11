"use client"; // Lo hacemos client component para manejar los filtros de estado

import { useState } from "react";

// 1. Mock de Datos (Simulando lo que vendrá de Laravel/PostgreSQL)
const PRODUCTS_MOCK = [
  {
    id: 1,
    name: "NVIDIA RTX 4080 Super",
    category: "GPU",
    price: 1199,
    stock: 5,
    image: "🎮",
    tag: "Nuevo",
  },
  {
    id: 2,
    name: "MacBook Pro M3 Max",
    category: "Laptops",
    price: 3499,
    stock: 0,
    image: "💻",
    tag: "Agotado",
  },
  {
    id: 3,
    name: "Logitech G Pro X Superlight",
    category: "Periféricos",
    price: 149,
    stock: 15,
    image: "🖱️",
    tag: "Popular",
  },
  {
    id: 4,
    name: 'Monitor ASUS ROG 27"',
    category: "Monitores",
    price: 699,
    stock: 8,
    image: "🖥️",
    tag: "Nuevo",
  },
  {
    id: 5,
    name: "Intel Core i9-14900K",
    category: "Componentes",
    price: 589,
    stock: 12,
    image: "💾",
    tag: null,
  },
  {
    id: 6,
    name: "Teclado Keychron Q1",
    category: "Periféricos",
    price: 169,
    stock: 3,
    image: "⌨️",
    tag: "Oferta",
  },
];

export default function ProductsPage() {
  const [filter, setFilter] = useState("Todos");

  const filteredProducts =
    filter === "Todos"
      ? PRODUCTS_MOCK
      : PRODUCTS_MOCK.filter((p) => p.category === filter);

  return (
    <div className="flex flex-col md:flex-row gap-8">
      {/* --- SIDEBAR DE FILTROS --- */}
      <aside className="w-full md:w-64 space-y-6">
        <div>
          <h2 className="text-lg font-bold mb-4 border-b pb-2">Categorías</h2>
          <nav className="flex flex-col gap-2">
            {[
              "Todos",
              "Laptops",
              "GPU",
              "Periféricos",
              "Monitores",
              "Componentes",
            ].map((cat) => (
              <button
                key={cat}
                onClick={() => setFilter(cat)}
                className={`text-left px-3 py-2 rounded-lg transition ${
                  filter === cat
                    ? "bg-blue-600 text-white shadow-md"
                    : "text-slate-600 hover:bg-slate-100"
                }`}
              >
                {cat}
              </button>
            ))}
          </nav>
        </div>

        <div className="p-4 bg-blue-50 rounded-xl border border-blue-100">
          <p className="text-xs text-blue-800 font-medium uppercase mb-2">
            Soporte Aria
          </p>
          <p className="text-xs text-blue-600 leading-tight">
            ¿Buscas una pieza específica? Contáctanos.
          </p>
        </div>
      </aside>

      {/* --- GRID DE PRODUCTOS --- */}
      <main className="flex-1">
        <div className="flex justify-between items-end mb-8">
          <div>
            <h1 className="text-3xl font-black text-slate-900">
              Catálogo de Hardware
            </h1>
            <p className="text-slate-500">
              Mostrando {filteredProducts.length} resultados
            </p>
          </div>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredProducts.map((product) => (
            <div
              key={product.id}
              className="group relative bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-blue-300 transition-all duration-300"
            >
              {/* Badge Dinámico */}
              {product.tag && (
                <span
                  className={`absolute top-3 left-3 z-10 px-2 py-1 text-[10px] font-bold uppercase rounded ${
                    product.tag === "Agotado"
                      ? "bg-red-500 text-white"
                      : "bg-blue-600 text-white"
                  }`}
                >
                  {product.tag}
                </span>
              )}

              {/* Imagen Placeholder */}
              <div className="aspect-square bg-slate-50 flex items-center justify-center text-6xl group-hover:scale-110 transition-transform duration-500">
                {product.image}
              </div>

              {/* Info del Producto */}
              <div className="p-5">
                <p className="text-xs font-bold text-blue-600 uppercase mb-1">
                  {product.category}
                </p>
                <h3 className="text-slate-800 font-bold text-lg mb-4 line-clamp-1">
                  {product.name}
                </h3>

                <div className="flex items-center justify-between mt-auto">
                  <span className="text-2xl font-black text-slate-900">
                    ${product.price.toLocaleString()}
                  </span>
                  <button
                    disabled={product.stock === 0}
                    className={`px-4 py-2 rounded-lg font-bold text-sm transition-all ${
                      product.stock === 0
                        ? "bg-slate-100 text-slate-400 cursor-not-allowed"
                        : "bg-slate-900 text-white hover:bg-blue-600 active:scale-95"
                    }`}
                  >
                    {product.stock === 0 ? "Sin Stock" : "Agregar"}
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      </main>
    </div>
  );
}
