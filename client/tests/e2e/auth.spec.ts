import { test, expect } from '@playwright/test';

test('TC-AUTH-001 - Inicio de sesión con credenciales válidas', async ({ page }) => {
  await page.goto('/login');

  await expect(
    page.getByRole('heading', { name: 'Bienvenido de nuevo' })
  ).toBeVisible();

  await page.locator('input[type="email"]').fill('admin@ariatechshop.com');

  await page.locator('input[type="password"]').fill('password');

  await page.getByRole('button', { name: 'Iniciar Sesión' }).click();

  await expect(page).toHaveURL(/\/$/);
});


test('TC-AUTH-002 - Inicio de sesión con credenciales inválidas', async ({ page }) => {
  await page.goto('/login');

  await expect(
    page.getByRole('heading', { name: 'Bienvenido de nuevo' })
  ).toBeVisible();

  // Usa el mismo correo válido que utilizaste en TC-AUTH-001.
  await page.locator('input[type="email"]').fill('admin@ariatechshop.com');

  // Contraseña deliberadamente incorrecta.
  await page.locator('input[type="password"]').fill('prueba');

  await page.getByRole('button', { name: 'Iniciar Sesión' }).click();

  // Debe mostrarse el mensaje de error.
  await expect(
    page.getByText('Credenciales incorrectas')
  ).toBeVisible();

  // Debe permanecer en la pantalla de login.
  await expect(page).toHaveURL(/\/login$/);
});