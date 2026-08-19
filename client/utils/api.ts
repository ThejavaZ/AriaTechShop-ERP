<<<<<<< HEAD
export const api = async (url: string) => {
  try {
    // Agregamos http y el prefijo /api
    const res = await fetch(`http://localhost:8000/api/${url}`, {
      cache: "no-store", // Para que siempre traiga datos frescos del ERP
=======
// lib/api.ts
export const api = async (endpoint: string, options: RequestInit = {}) => {
  try {
    const baseUrl = process.env.NEXT_PUBLIC_API_URL;
    const url = `${baseUrl?.replace(/\/$/, "")}/${endpoint.replace(/^\//, "")}`;

    const res = await fetch(url, {
      ...options,
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        ...options.headers,
      },
      cache: "no-store",
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
    });

    const data = await res.json();

<<<<<<< HEAD
    if (!data.success) return null;
    return data.data;
  } catch (error) {
    console.error("Error consumiendo la API de Aria:", error);
    return null;
=======
    if (!res.ok) {
      return { error: true, errors: data.errors, message: data.message };
    }

    return { error: false, data: data.data || data };
  } catch (error) {
    console.error("Error en API:", error);
    return { error: true, message: "Error de conexión" };
>>>>>>> 92925bac025897d0d44f08032ee7ee60e5a198dc
  }
};
