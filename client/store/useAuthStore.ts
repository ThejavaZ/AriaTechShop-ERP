import { create } from "zustand";
import { persist } from "zustand/middleware";

interface AuthState {
  user: any | null;
  token: string | null;
  setAuth: (user: any, token: string) => void;
  logout: () => void;
}

export const useAuthStore = create<AuthState>()(
  persist(
    (set) => ({
      user: null,
      token: null,
      setAuth: (user, token) => set({ user, token }),
      logout: () => {
        localStorage.removeItem("aria_token");
        localStorage.removeItem("aria_user");
        set({ user: null, token: null });
      },
    }),
    { name: "aria-auth" }, // Esto lo guarda automáticamente en localStorage
  ),
);
