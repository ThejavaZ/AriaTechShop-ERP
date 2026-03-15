import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  transpilePackages: ["lucide-react"],
  // turbo va afuera de experimental
  turbo: {
    root: "..",
  },
  experimental: {
    // Aquí puedes dejar otras cosas, pero NO turbo
  },
};

export default nextConfig;
