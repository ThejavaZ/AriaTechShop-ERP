import Link from "next/link";

export default function HomePage() {
  return (
    <div className="space-y-20 pb-20">
      {/* 1. HERO SECTION: El gancho visual */}
      <section className="relative overflow-hidden rounded-3xl bg-slate-900 px-8 py-20 text-white shadow-2xl">
        <div className="relative z-10 max-w-2xl">
          <span className="mb-4 inline-block rounded-full bg-blue-500/20 px-4 py-1 text-sm font-semibold text-blue-400">
            Nueva Generación RTX 50-Series disponible
          </span>
          <h1 className="mb-6 text-5xl font-extrabold tracking-tight lg:text-6xl">
            Potencia tu setup con{" "}
            <span className="text-blue-500">Aria Tech</span>
          </h1>
          <p className="mb-8 text-lg text-slate-400">
            Hardware de alto rendimiento, periféricos premium y soporte técnico
            especializado para entusiastas del gaming y profesionales.
          </p>
          <div className="flex flex-wrap gap-4">
            <Link
              href="/productos"
              className="rounded-xl bg-blue-600 px-8 py-4 font-bold transition hover:bg-blue-700 active:scale-95"
            >
              Explorar Catálogo
            </Link>
            <Link
              href="/nosotros"
              className="rounded-xl border border-slate-700 bg-slate-800/50 px-8 py-4 font-bold backdrop-blur-sm transition hover:bg-slate-800"
            >
              Soporte Técnico
            </Link>
          </div>
        </div>

        {/* Decoración abstracta de fondo */}
        <div className="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>
        <div className="absolute -bottom-20 right-20 h-64 w-64 rounded-full bg-indigo-600/10 blur-3xl"></div>
      </section>

      {/* 2. CATEGORÍAS RÁPIDAS: Iconos o Cards pequeñas */}
      <section>
        <div className="mb-8 flex items-end justify-between">
          <div>
            <h2 className="text-3xl font-bold">Categorías Populares</h2>
            <p className="text-slate-500">Busca por tipo de componente</p>
          </div>
          <Link
            href="/categorias"
            className="text-sm font-semibold text-blue-600 hover:underline"
          >
            Ver todas &rarr;
          </Link>
        </div>

        <div className="grid grid-cols-2 gap-4 md:grid-cols-4">
          {["Laptops", "GPU", "Teclados", "Monitores"].map((cat) => (
            <div
              key={cat}
              className="group cursor-pointer rounded-2xl border border-slate-200 bg-white p-6 transition hover:border-blue-300 hover:shadow-lg"
            >
              <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 transition group-hover:bg-blue-100">
                {/* Aquí iría un icono */}
                <span className="text-2xl">💻</span>
              </div>
              <h3 className="font-bold text-slate-800">{cat}</h3>
              <p className="text-sm text-slate-500">20+ productos</p>
            </div>
          ))}
        </div>
      </section>

      {/* 3. PRODUCTOS DESTACADOS: Grid de Cards */}
      <section>
        <h2 className="mb-8 text-3xl font-bold">Lo más buscado</h2>
        <div className="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          {/* Card de Producto de ejemplo */}
          <div className="overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:shadow-xl">
            <div className="aspect-square bg-slate-100">
              {/* Imagen del producto */}
              <div className="flex h-full items-center justify-center text-slate-400">
                Imagen Producto
              </div>
            </div>
            <div className="p-6">
              <h3 className="mb-2 text-xl font-bold">
                NVIDIA GeForce RTX 5080
              </h3>
              <p className="mb-4 text-sm text-slate-500">
                16GB GDDR7 - Arquitectura Blackwell
              </p>
              <div className="flex items-center justify-between">
                <span className="text-2xl font-black text-blue-600">
                  $1,199.00
                </span>
                <button className="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                  Agregar
                </button>
              </div>
            </div>
          </div>
          {/* ... Repetir cards */}
        </div>
      </section>
    </div>
  );
}
