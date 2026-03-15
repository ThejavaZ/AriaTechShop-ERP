import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  transpilePackages: ["lucide-react"],
  experimental: {
    // Aquí puedes dejar otras cosas, pero NO turbo
  },
};

export default nextConfig;
