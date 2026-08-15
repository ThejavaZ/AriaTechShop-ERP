"use client";

import { useState, useEffect } from "react";
import { useCartStore } from "@/store/useCartStore";
import { api } from "@/utils/api";

export default function ProductsPage() {
  const [products, setProducts] = useState([]);
  const [categories, setCategories] = useState([]);
  const [filter, setFilter] = useState("Todos");
  const [loading, setLoading] = useState(true);

  const addToCart = useCartStore((state) => state.addToCart);

  // Carga inicial de datos
<<<<<<< HEAD
  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);
      const [prodData, catData] = await Promise.all([
        api("products"),
        api("categories"),
      ]);

      if (prodData) setProducts(prodData);
      if (catData) setCategories(catData);
=======
  // Carga inicial de datos
  useEffect(() => {
    const fetchData = async () => {
      setLoading(true);

      // Recuerda que ahora api() devuelve { error, data }
      const [prodRes, catRes] = await Promise.all([
        api("products"), // Asegúrate que el endpoint sea correcto
        api("categories"),
      ]);

      // Solo actualizamos si no hubo error y hay data
      if (prodRes && !prodRes.error) {
        setProducts(prodRes.data);
      }

      if (catRes && !catRes.error) {
        setCategories(catRes.data); // <--- AQUÍ: Pasamos el array real
      }

>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
      setLoading(false);
    };

    fetchData();
  }, []);

  // Filtrado lógico (usando el objeto categoría de Laravel)
  const filteredProducts =
    filter === "Todos"
      ? products
      : products.filter((p: any) => p.category?.name === filter);

  if (loading)
    return (
      <div className="p-10 text-center font-bold">
        Cargando Hardware de Aria...
      </div>
    );

  return (
    <div className="flex flex-col md:flex-row gap-8">
      {/* --- SIDEBAR DE FILTROS --- */}
      <aside className="w-full md:w-64 space-y-6">
        <div>
          <h2 className="text-lg font-bold mb-4 border-b pb-2">Categorías</h2>
          <nav className="flex flex-col gap-2">
            <button
              onClick={() => setFilter("Todos")}
              className={`text-left px-3 py-2 rounded-lg transition ${
                filter === "Todos"
                  ? "bg-blue-600 text-white"
                  : "text-slate-600 hover:bg-slate-100"
              }`}
            >
              Todos
            </button>
<<<<<<< HEAD
            {categories.map((cat: any) => (
              <button
                key={cat.id}
                onClick={() => setFilter(cat.name)}
                className={`text-left px-3 py-2 rounded-lg transition ${
                  filter === cat.name
                    ? "bg-blue-600 text-white"
                    : "text-slate-600 hover:bg-slate-100"
                }`}
              >
                {cat.name}
              </button>
            ))}
=======
            {Array.isArray(categories) &&
              categories.map((cat: any) => (
                <button
                  key={cat.id}
                  onClick={() => setFilter(cat.name)}
                  className={`text-left px-3 py-2 rounded-lg transition ${
                    filter === cat.name
                      ? "bg-blue-600 text-white"
                      : "text-slate-600 hover:bg-slate-100"
                  }`}
                >
                  {cat.name}
                </button>
              ))}
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
          </nav>
        </div>
      </aside>

      {/* --- GRID DE PRODUCTOS --- */}
      <main className="flex-1">
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredProducts.map((product: any) => (
            <div
              key={product.id}
              className="group relative bg-white border border-slate-200 rounded-2xl overflow-hidden hover:shadow-2xl transition-all"
            >
              {/* Badge Dinámico (Basado en stock real) */}
              {product.stock === 0 && (
                <span className="absolute top-3 left-3 z-10 px-2 py-1 text-[10px] font-bold uppercase rounded bg-red-500 text-white">
                  Agotado
                </span>
              )}

              {/* Imagen: Usamos el image_url de la DB o un emoji por defecto */}
              <div className="aspect-square bg-slate-50 flex items-center justify-center text-6xl">
                {product.image_url ? (
                  <img src={product.image_url} alt={product.name} />
                ) : (
                  "📦"
                )}
              </div>

              <div className="p-5">
                <p className="text-xs font-bold text-blue-600 uppercase mb-1">
                  {product.category?.name || "General"}
                </p>
                <h3 className="text-slate-800 font-bold text-lg mb-4">
                  {product.name}
                </h3>

                <div className="flex items-center justify-between mt-auto">
                  <span className="text-2xl font-black text-slate-900">
                    ${parseFloat(product.price).toLocaleString()}
                  </span>
                  <button
                    disabled={product.stock === 0}
                    onClick={() => addToCart(product)} // Ahora pasamos el objeto real
                    className={`px-4 py-2 rounded-lg font-bold text-sm transition-all ${
                      product.stock === 0
                        ? "bg-slate-100 text-slate-400"
                        : "bg-slate-900 text-white hover:bg-blue-600"
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
