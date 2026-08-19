// eslint.config.js
import js from "@eslint/js";

export default [
  js.configs.recommended,
  {
    files: ["server/resources/js/**/*.js"],
    ignores: [
      "node_modules/**",
      "public/**",
      "dist/**",
      "vendor/**",
      "storage/**"
    ],
    languageOptions: {
      ecmaVersion: "latest",
      sourceType: "module",
      globals: {
        window: "readonly",
        document: "readonly",
        localStorage: "readonly",
        console: "readonly",
        simpleDatatables: "readonly",
        d3: "readonly"
      },
    },
    rules: {
      "no-unused-vars": "error",
      "no-var": "error",
    },
  },
];
