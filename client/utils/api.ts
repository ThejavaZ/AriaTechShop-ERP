export const api = async (url: string) => {
  try {
    // Agregamos http y el prefijo /api
    const res = await fetch(`http://localhost:8000/api/${url}`, {
      cache: "no-store", // Para que siempre traiga datos frescos del ERP
    });

    const data = await res.json();

    if (!data.success) return null;
    return data.data;
  } catch (error) {
    console.error("Error consumiendo la API de Aria:", error);
    return null;
  }
};
