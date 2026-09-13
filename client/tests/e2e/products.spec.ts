import { test, expect } from '@playwright/test';

test('TC-PROD-001 - Visualización del catálogo de productos', async ({ page }) => {
  await page.goto('/products');

  await expect(page).toHaveURL(/\/products$/);

  await expect(
    page.getByText('Categorías', { exact: true })
  ).toBeVisible();

  await expect(
    page.getByRole('button', { name: 'Todos', exact: true })
  ).toBeVisible();

  await expect(
    page.getByText('Hardware de Aria', { exact: true })
  ).not.toBeVisible();
});



test('TC-PROD-002 - Visualización de productos con filtro Todos', async ({ page }) => {
  await page.goto('/products');

  await expect(page).toHaveURL(/\/products$/);

  const todosButton = page.getByRole('button', {
    name: 'Todos',
    exact: true,
  });

  await expect(todosButton).toBeVisible();

  await todosButton.click();

  await expect(todosButton).toHaveClass(/bg-blue-600/);
});


test('TC-PROD-003 - Catálogo sin productos', async ({ page }) => {
  await page.goto('/products');

  await expect(page).toHaveURL(/\/products$/);

  await expect(
    page.getByText('Categorías', { exact: true })
  ).toBeVisible();

  await expect(
    page.getByRole('button', {
      name: 'Todos',
      exact: true,
    })
  ).toBeVisible();

  // El catálogo debe cargar sin mostrar tarjetas de productos.
  await expect(
    page.locator('main .group')
  ).toHaveCount(0);
});