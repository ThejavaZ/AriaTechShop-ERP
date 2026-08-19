"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { User, Mail, Shield, Globe, Power, Package } from "lucide-react";
import { useAuthStore } from "@/store/useAuthStore";

export default function ProfilePage() {
  const [user, setUser] = useState<any>(null);
  const router = useRouter();
  const { logout } = useAuthStore();

  useEffect(() => {
    // 1. Extraemos los datos que guardamos en el login
    const storedUser = localStorage.getItem("aria_user");
    const token = localStorage.getItem("aria_token");

    if (!storedUser || !token) {
      // Si no hay sesión, al login de una
      router.push("/login");
    } else {
      setUser(JSON.parse(storedUser));
    }
  }, [router]);

  const handleLogout = () => {
    logout(); // Esto limpia el estado y el localStorage al mismo tiempo
    router.push("/login");
  };

  if (!user)
    return <div className="p-10 text-center font-bold">Cargando perfil...</div>;

  return (
    <div className="max-w-4xl mx-auto py-12 px-4">
      {/* Header del Perfil */}
      <div className="relative bg-slate-900 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
        <div className="relative z-10 flex flex-col md:flex-row items-center gap-6">
          <div className="w-24 h-24 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-4xl font-black shadow-lg">
            {user.name.charAt(0)}
          </div>
          <div className="text-center md:text-left">
            <h1 className="text-3xl font-black text-white">{user.name}</h1>
            <p className="text-blue-400 font-medium">
              {user.role || "Usuario de Aria"}
            </p>
          </div>
          <button
            onClick={handleLogout}
            className="md:ml-auto flex items-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-6 py-3 rounded-xl font-bold transition-all active:scale-95"
          >
            <Power size={18} /> Cerrar Sesión
          </button>
        </div>
        {/* Decoración de fondo */}
        <div className="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
        {/* Columna de Detalles */}
        <div className="md:col-span-2 space-y-6">
          <section className="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
            <h2 className="text-xl font-black text-slate-900 mb-6">
              Información Personal
            </h2>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div className="space-y-1">
                <p className="text-xs font-bold text-slate-400 uppercase">
                  Correo Electrónico
                </p>
                <div className="flex items-center gap-2 text-slate-700 font-medium">
                  <Mail size={16} className="text-blue-500" /> {user.email}
                </div>
              </div>
              <div className="space-y-1">
                <p className="text-xs font-bold text-slate-400 uppercase">
                  Rol de Usuario
                </p>
                <div className="flex items-center gap-2 text-slate-700 font-medium">
                  <Shield size={16} className="text-blue-500" />{" "}
                  {user.role || "Vendedor"}
                </div>
              </div>
              <div className="space-y-1">
                <p className="text-xs font-bold text-slate-400 uppercase">
                  Idioma
                </p>
                <div className="flex items-center gap-2 text-slate-700 font-medium">
                  <Globe size={16} className="text-blue-500" />{" "}
                  {user.language === "es" ? "Español" : "English"}
                </div>
              </div>
              <div className="space-y-1">
                <p className="text-xs font-bold text-slate-400 uppercase">
                  Estado
                </p>
                <div className="flex items-center gap-2">
                  <span className="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                  <span className="text-slate-700 font-medium">Activo</span>
                </div>
              </div>
            </div>
          </section>

          {/* Sección de Actividad (Simulada) */}
          <section className="bg-white border border-slate-100 rounded-3xl p-8 shadow-sm">
            <h2 className="text-xl font-black text-slate-900 mb-4 text-center sm:text-left">
              Actividad Reciente
            </h2>
            <div className="flex flex-col items-center justify-center py-8 text-slate-400">
              <Package size={48} className="mb-4 opacity-20" />
              <p className="font-medium">
                No hay ventas registradas recientemente.
              </p>
            </div>
          </section>
        </div>

        {/* Sidebar de Perfil / Estadísticas */}
        <div className="space-y-6">
          <div className="bg-blue-600 rounded-3xl p-8 text-white shadow-xl shadow-blue-200">
            <h3 className="text-lg font-black mb-2">Resumen Aria</h3>
            <p className="text-blue-100 text-sm mb-6 leading-relaxed">
              Has estado activo desde marzo de 2026. Tu nivel de acceso permite
              gestionar inventario.
            </p>
            <div className="text-3xl font-black italic opacity-50 text-right">
              #AriaCore
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
