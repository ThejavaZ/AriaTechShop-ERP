import { test, expect } from '@playwright/test';

test('TC-SALES-001 - Acceso al módulo de ventas autenticado', async ({ page }) => {
    const email = process.env.PLAYWRIGHT_TEST_EMAIL;
    const password = process.env.PLAYWRIGHT_TEST_PASSWORD;

    if (!email || !password) {
        throw new Error(
            'Faltan PLAYWRIGHT_TEST_EMAIL o PLAYWRIGHT_TEST_PASSWORD'
        );
    }

    // Primero entramos al login de Laravel.
    await page.goto('http://127.0.0.1:8000/auth/login');

    await expect(
        page.locator('input[type="email"]')
    ).toBeVisible();

    await page.locator('input[type="email"]').fill(email);
    await page.locator('input[type="password"]').fill(password);

    await page.getByRole('button', { name: /iniciar sesión|login/i }).click();

    // Comprobamos que el login fue exitoso.
    await expect(page).toHaveURL(/\/(home|dashboard|$)/);

    // Entramos al módulo de ventas.
    await page.goto('http://127.0.0.1:8000/sales');

    // Debemos permanecer en ventas y no ser enviados nuevamente al login.
    await expect(page).toHaveURL(/\/sales$/);

    // La página de ventas debe contener su encabezado.
    await expect(
        page.getByText(/ventas/i).first()
    ).toBeVisible();
});

test('TC-SALES-002 - Visualización del listado de ventas', async ({ page }) => {
    const email = process.env.PLAYWRIGHT_TEST_EMAIL;
    const password = process.env.PLAYWRIGHT_TEST_PASSWORD;

    if (!email || !password) {
        throw new Error(
            'Faltan PLAYWRIGHT_TEST_EMAIL o PLAYWRIGHT_TEST_PASSWORD'
        );
    }

    // Iniciar sesión en Laravel.
    await page.goto('http://127.0.0.1:8000/auth/login');

    await page.locator('input[type="email"]').fill(email);
    await page.locator('input[type="password"]').fill(password);

    await page.getByRole('button', { name: /iniciar sesión|login/i }).click();

    // Acceder al módulo de ventas.
    await page.goto('http://127.0.0.1:8000/sales');

    await expect(page).toHaveURL(/\/sales$/);

    // Verificar que el módulo de ventas se muestra correctamente.
    await expect(
        page.getByText('Ventas', { exact: true }).first()
    ).toBeVisible();
});


test('TC-SALES-003 - Acceso al formulario de registro de venta', async ({ page }) => {
    const email = process.env.PLAYWRIGHT_TEST_EMAIL;
    const password = process.env.PLAYWRIGHT_TEST_PASSWORD;

    if (!email || !password) {
        throw new Error(
            'Faltan PLAYWRIGHT_TEST_EMAIL o PLAYWRIGHT_TEST_PASSWORD'
        );
    }

    // Iniciar sesión en Laravel.
    await page.goto('http://127.0.0.1:8000/auth/login');

    await page.locator('input[type="email"]').fill(email);
    await page.locator('input[type="password"]').fill(password);

    await page.getByRole('button', { name: /iniciar sesión|login/i }).click();

    // Acceder al módulo de ventas.
    await page.goto('http://127.0.0.1:8000/sales');

    await expect(page).toHaveURL(/\/sales$/);

    // Acceder al formulario para registrar una venta.
    await page.getByRole('link', { name: 'Registrar venta' }).click();

    // Debemos salir del listado y entrar al formulario.
    await expect(page).not.toHaveURL(/\/sales$/);
});

test('TC-SALES-004 - Visualización del formulario de nueva venta', async ({ page }) => {
    const email = process.env.PLAYWRIGHT_TEST_EMAIL;
    const password = process.env.PLAYWRIGHT_TEST_PASSWORD;

    if (!email || !password) {
        throw new Error(
            'Faltan PLAYWRIGHT_TEST_EMAIL o PLAYWRIGHT_TEST_PASSWORD'
        );
    }

    // Iniciar sesión en Laravel.
    await page.goto('http://127.0.0.1:8000/auth/login');

    await page.locator('input[type="email"]').fill(email);
    await page.locator('input[type="password"]').fill(password);

    await page.getByRole('button', { name: /iniciar sesión|login/i }).click();

    // Acceder directamente al formulario de nueva venta.
    await page.goto('http://127.0.0.1:8000/sales/create');

    await expect(page).toHaveURL(/\/sales\/create$/);

    // Verificar el título del formulario.
    await expect(
        page.getByRole('heading', { name: 'Nueva Venta' })
    ).toBeVisible();

    // Verificar los campos principales.
    await expect(page.getByText('Factura', { exact: true })).toBeVisible();
    await expect(page.getByText('Fecha de venta', { exact: true })).toBeVisible();
    await expect(page.getByText('Cliente', { exact: true })).toBeVisible();
    await expect(page.getByText('Teléfono', { exact: true })).toBeVisible();
    await expect(page.getByText('Email', { exact: true })).toBeVisible();
    await expect(page.getByText('Subtotal', { exact: true })).toBeVisible();
    await expect(page.getByText('Impuesto', { exact: true })).toBeVisible();
    await expect(page.getByText('Total', { exact: true })).toBeVisible();
    await expect(page.getByText('Método de pago', { exact: true })).toBeVisible();

    // Debe existir un selector para el método de pago.
    await expect(page.locator('select')).toBeVisible();
});

test('TC-SALES-005 - Validación de campos obligatorios en nueva venta', async ({ page }) => {
    const email = process.env.PLAYWRIGHT_TEST_EMAIL;
    const password = process.env.PLAYWRIGHT_TEST_PASSWORD;

    if (!email || !password) {
        throw new Error(
            'Faltan PLAYWRIGHT_TEST_EMAIL o PLAYWRIGHT_TEST_PASSWORD'
        );
    }

    // Iniciar sesión.
    await page.goto('http://127.0.0.1:8000/auth/login');

    await page.locator('input[type="email"]').fill(email);
    await page.locator('input[type="password"]').fill(password);

    await page.getByRole('button', { name: /iniciar sesión|login/i }).click();

    // Abrir nueva venta.
    await page.goto('http://127.0.0.1:8000/sales/create');

    await expect(page).toHaveURL(/\/sales\/create$/);

    await page.locator('form[action="/sales"]').evaluate((form) => {
        (form as HTMLFormElement).requestSubmit();
    });
    // El primer campo obligatorio debe quedar inválido.
    const firstRequiredField = page.locator('[required]').first();

    await expect(firstRequiredField).toBeVisible();

    const validationMessage = await firstRequiredField.evaluate(
        (element: HTMLInputElement) => element.validationMessage
    );

    expect(validationMessage).toBeTruthy();

    // La venta no debe registrarse.
    await expect(page).toHaveURL(/\/sales\/create$/);
});