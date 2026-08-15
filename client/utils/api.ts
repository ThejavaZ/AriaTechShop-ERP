// lib/api.ts
export const api = async (endpoint: string, options: RequestInit = {}) => {
  try {
    const baseUrl = process.env.NEXT_PUBLIC_API_URL;
    const url = `${baseUrl?.replace(/\/$/, "")}/${endpoint.replace(/^\//, "")}`;

    const token =
      typeof window !== "undefined" ? localStorage.getItem("aria_token") : null;

    const res = await fetch(url, {
      ...options,
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
        ...options.headers,
      },
      cache: "no-store",
    });

    const data = await res.json();

    if (!res.ok) {
      return { error: true, errors: data.errors, message: data.message };
    }

    return { error: false, data: data.data || data };
  } catch (error) {
    console.error("Error en API:", error);
    return { error: true, message: "Error de conexión" };
  }
};
