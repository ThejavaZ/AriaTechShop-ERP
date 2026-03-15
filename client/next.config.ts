// next.config.ts
import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  transpilePackages: ["lucide-react"], // Aprovechando que la usas
  experimental: {
    turbo: {
      root: process.cwd(), // O prueba con process.cwd() si no funciona
    },
  },
};

export default nextConfig;
