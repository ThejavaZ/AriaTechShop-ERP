"use client";

import { useState } from "react";
import Link from "next/link";
import { useCartStore } from "@/store/useCartStore";
import { ShoppingCart, User, Search, Menu, X } from "lucide-react"; // Importamos iconos claros

export default function Header() {
  const [isOpen, setIsOpen] = useState(false);
  // Por ahora hardcodeamos el contador, luego vendrá de Zustand
  const cartCount = useCartStore((state) => state.count);

  const toggleMenu = () => setIsOpen(!isOpen);

  return (
    <header className="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-16">
          {/* 1. LOGO */}
          <div className="shrink-0 flex items-center">
            <Link
              href="/"
              className="text-xl font-extrabold bg-linear-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"
            >
              Aria TechShop
            </Link>
          </div>

          {/* 2. DESKTOP NAV (Centro) */}
          <nav className="hidden md:flex space-x-8">
            <Link
              href="/"
              className="text-gray-700 hover:text-blue-600 font-medium transition"
            >
              Inicio
            </Link>
            <Link
              href="/products"
              className="text-gray-700 hover:text-blue-600 font-medium transition"
            >
              Productos
            </Link>
            <Link
              href="/about"
              className="text-gray-700 hover:text-blue-600 font-medium transition"
            >
              Nosotros
            </Link>
          </nav>

          {/* 3. ACCIONES (Derecha) */}
          <div className="flex items-center gap-2 sm:gap-4">
            {/* Búsqueda (Opcional por ahora) */}
            <button className="p-2 text-gray-600 hover:text-blue-600 transition hidden sm:block">
              <Search size={20} />
            </button>

            {/* Carrito con Badge */}
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

            {/* Usuario / Login */}
            <Link
              href="/login"
              className="flex items-center gap-2 p-2 text-gray-600 hover:text-blue-600 transition border-l pl-4 ml-2"
            >
              <User size={22} />
              <span className="hidden lg:inline text-sm font-semibold">
                Entrar
              </span>
            </Link>

            {/* Botón Hamburguesa (Móvil) */}
            <button
              onClick={toggleMenu}
              className="md:hidden text-gray-600 hover:text-blue-600 p-2"
            >
              {isOpen ? <X size={28} /> : <Menu size={28} />}
            </button>
          </div>
        </div>
      </div>

      {/* MENÚ MÓVIL */}
      <div
        className={`md:hidden overflow-hidden transition-all duration-300 ease-in-out bg-white ${isOpen ? "max-h-64 border-t border-gray-100 shadow-lg" : "max-h-0"}`}
      >
        <div className="px-4 pt-2 pb-6 space-y-1">
          <Link
            href="/"
            onClick={toggleMenu}
            className="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600"
          >
            Inicio
          </Link>
          <Link
            href="/products"
            onClick={toggleMenu}
            className="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600"
          >
            Productos
          </Link>
          <Link
            href="/about"
            onClick={toggleMenu}
            className="block px-3 py-3 rounded-md text-base font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600"
          >
            Nosotros
          </Link>
          <div className="pt-4 border-t border-gray-100">
            <Link
              href="/login"
              onClick={toggleMenu}
              className="flex justify-center bg-blue-600 text-white py-3 rounded-xl font-bold"
            >
              Iniciar Sesión
            </Link>
          </div>
        </div>
      </div>
    </header>
  );
}
