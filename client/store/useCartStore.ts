import { create } from "zustand";
import { persist } from "zustand/middleware"; // Opcional: para que no se borre al recargar

interface Product {
  id: number;
  name: string;
  price: number;
  stock: number;
  image?: string; // Agregado por si usas imágenes en tu catálogo
}

interface CartState {
  cart: Product[];
  count: number;
  addToCart: (product: Product) => void;
  removeFromCart: (productId: number) => void;
  clearCart: () => void;
}

export const useCartStore = create<CartState>()(
  persist(
    (set) => ({
      cart: [],
      count: 0,

      // Ahora sí recibimos el product y actualizamos ambos estados
      addToCart: (product: Product) =>
        set((state) => {
          const newCart = [...state.cart, product];
          return {
            cart: newCart,
            count: newCart.length,
          };
        }),

      // Función extra para que tu UI sea funcional
      removeFromCart: (productId: number) =>
        set((state) => {
          const newCart = state.cart.filter((p) => p.id !== productId);
          return {
            cart: newCart,
            count: newCart.length,
          };
        }),

      clearCart: () => set({ cart: [], count: 0 }),
    }),
    {
      name: "aria-cart-storage", // Nombre de la cookie/localStorage
    },
  ),
);
