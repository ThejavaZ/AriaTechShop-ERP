import { create } from "zustand";

interface CartState {
  count: number;
  addToCart: () => void;
  clearCart: () => void;
}

export const useCartStore = create<CartState>((set) => ({
  count: 0,
  // Función para incrementar el contador
  addToCart: () => set((state) => ({ count: state.count + 1 })),
  // Función para resetear (útil para cuando el usuario cierre sesión)
  clearCart: () => set({ count: 0 }),
}));
