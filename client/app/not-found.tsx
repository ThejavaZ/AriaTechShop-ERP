import Link from "next/link";
import { AlertCircle, Home } from "lucide-react";

export default function NotFound() {
  return (
    <div className="min-h-[70vh] flex flex-col items-center justify-center px-4 text-center">
      <div className="bg-blue-50 p-6 rounded-full mb-6">
        <AlertCircle size={64} className="text-blue-600" />
      </div>
      <h1 className="text-4xl font-black text-slate-900 mb-2">
        404 - ¡Ups! Perdido en la red
      </h1>
      <p className="text-gray-500 max-w-md mb-8">
        Parece que este componente no está en nuestro inventario. Pero no te
        preocupes, aún tenemos mucho hardware para ti.
      </p>
      <Link
        href="/"
        className="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-blue-600 transition-all shadow-xl shadow-blue-100"
      >
        <Home size={20} /> Volver al Inicio
      </Link>
    </div>
  );
}
