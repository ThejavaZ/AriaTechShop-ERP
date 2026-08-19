"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { useCartStore } from "@/store/useCartStore";
import { ShoppingCart, User, Search, Menu, X } from "lucide-react";
import { useAuthStore } from "@/store/useAuthStore";

export default function Header() {
  const { user } = useAuthStore(); // Zustand ya sabe si hay usuario
  const cartCount = useCartStore((state) => state.count);

  const [isOpen, setIsOpen] = useState(false);
  const [mounted, setMounted] = useState(false);

  // 1. Solución al "Hydration Error" de Next.js
  // Esperamos a que el componente se monte en el cliente antes de mostrar datos del Store
  useEffect(() => {
    setMounted(true);
  }, []);

  const toggleMenu = () => setIsOpen(!isOpen);

  if (!mounted) return null; // Evita el parpadeo de hidratación

  return (
    <header className="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          {/* Logo */}
          <div className="shrink-0 flex items-center">
            <Link
              href="/"
              className="text-xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"
            >
              Aria TechShop
            </Link>
          </div>

          {/* Desktop Nav */}
          <nav className="hidden md:flex space-x-8">
            <Link
              href="/"
              className="text-gray-700 hover:text-blue-600 font-medium"
            >
              Inicio
            </Link>
            <Link
              href="/products"
              className="text-gray-700 hover:text-blue-600 font-medium"
            >
              Productos
            </Link>
            <Link
              href="/about"
              className="text-gray-700 hover:text-blue-600 font-medium"
            >
              Nosotros
            </Link>
          </nav>

          {/* Acciones */}
          <div className="flex items-center gap-2 sm:gap-4">
            <Link
              href="/cart"
              className="relative p-2 text-gray-600 hover:text-blue-600 transition"
            >
              <ShoppingCart size={22} />
              {cartCount > 0 && (
                <span className="absolute top-0 right-0 bg-blue-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                  {cartCount}
                </span>
              )}
            </Link>

            {/* --- LÓGICA DE USUARIO SIMPLIFICADA --- */}
            {user ? (
              <Link
                href="/profile"
                className="flex items-center gap-2 p-2 text-blue-600 bg-blue-50 rounded-xl transition border-l pl-4 ml-2 hover:bg-blue-100"
              >
                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-md">
                  {user.name.charAt(0)}
                </div>
                <span className="hidden lg:inline text-sm font-bold">
                  {user.name.split(" ")[0]}
                </span>
              </Link>
            ) : (
              <Link
                href="/login"
                className="flex items-center gap-2 p-2 text-gray-600 hover:text-blue-600 transition border-l pl-4 ml-2"
              >
                <User size={22} />
                <span className="hidden lg:inline text-sm font-semibold">
                  Entrar
                </span>
              </Link>
            )}

            <button
              onClick={toggleMenu}
              className="md:hidden text-gray-600 p-2"
            >
              {isOpen ? <X size={28} /> : <Menu size={28} />}
            </button>
          </div>
        </div>
      </div>

      {/* MENÚ MÓVIL ADAPTADO */}
      <div
        className={`md:hidden overflow-hidden transition-all duration-300 bg-white ${isOpen ? "max-h-96 border-t shadow-lg" : "max-h-0"}`}
      >
        <div className="px-4 pt-2 pb-6 space-y-1">
          <Link
            href="/"
            onClick={toggleMenu}
            className="block px-3 py-3 rounded-md font-medium text-gray-700"
          >
            Inicio
          </Link>
          <Link
            href="/products"
            onClick={toggleMenu}
            className="block px-3 py-3 rounded-md font-medium text-gray-700"
          >
            Productos
          </Link>

          <Link
            href="/about"
            onClick={toggleMenu}
            className="block px-3 py-3 rounded-md font-medium text-gray-700"
          >
            Nosotros
          </Link>

          <div className="pt-4 border-t border-gray-100">
            {user ? (
              <Link
                href="/profile"
                className="flex items-center gap-2 p-2 text-blue-600 bg-blue-50 rounded-xl transition border-l pl-4 ml-2 hover:bg-blue-100"
              >
                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-200">
                  {user.name.charAt(0)}
                </div>
                <span className="hidden lg:inline text-sm font-bold">
                  {user.name.split(" ")[0]}
                </span>
              </Link>
            ) : (
              <Link href="/login" className="...">
                <User size={22} />
                <span className="hidden lg:inline text-sm font-semibold">
                  Entrar
                </span>
              </Link>
            )}
          </div>
        </div>
      </div>
    </header>
  );
}
