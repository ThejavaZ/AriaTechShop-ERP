import tseslint from '@typescript-eslint/eslint-plugin';
import tsParser from '@typescript-eslint/parser';

export default tseslint.config({
  languageOptions: {
    parser: tsParser,
    parserOptions: { ecmaVersion: 2022, sourceType: 'module' },
    plugins: [tseslint],
  },
  rules: {
    '@typescript-eslint/explicit-function-type': 'off',
  },
})