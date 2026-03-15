// lib/api.ts
export const api = async (endpoint: string, options: RequestInit = {}) => {
  try {
    const baseUrl = process.env.NEXT_PUBLIC_API_URL;

    const res = await fetch(`${baseUrl}${endpoint}`, {
      ...options,
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
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
