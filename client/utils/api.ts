export const api = async (url: string) => {
  const res = await fetch(`localhost:8000/${url}`);
  const data = await res.json();
  if (!data) return "No info";
  return data.data;
};
