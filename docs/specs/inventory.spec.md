---
id: INV-001
title: Registro y control de inventario
status: stable
updated: 2026-09-12
owner: Javier Armando Sarmiento Gil
related_issue: null
tests: server/tests/Feature/InventoryTest.php
---

# Spec INV-001 — Registro y control de inventario

## 1. Resumen

El sistema debe permitir registrar productos de hardware, consultarlos, actualizar
su precio y ajustar el stock (incluyendo reposiciones), de modo que el inventario
del ERP siempre refleje la existencia real.

## 2. Requerimientos (criterios de aceptación)

- REQ-1.1 El usuario autenticado puede registrar un producto con **nombre, categoría, precio, stock y descripción**. El sistema lo persiste y redirige al índice.
- REQ-1.2 El índice muestra los productos registrados (vista `inventory.index`) con la variable `products`.
- REQ-1.3 El precio de un producto puede actualizarse.
- REQ-1.4 El stock puede incrementarse mediante **reposición** (restock).
- REQ-1.5 El stock puede **ajustarse manualmente**.

## 3. Contexto

- Backend Laravel 12, controlador web `InventoryController` (`routes/web.php`), modelo `Inventory`.
- Módulo heredado con operaciones CRUD parciales (ver diagnóstico PR #128).

## 4. Dependencias

- Autenticación web (`auth` middleware).
- Tabla `inventories`.

## 5. Plan

| Fase | Descripción | Estado |
|---|---|---|
| P1 | Levantar rutas/controlador existentes y tests de humo | ✅ |
| P2 | Cobertura CRUD con casos TC-016..TC-020 | ✅ |
| P3 | Integrar a UI de Livewire (navegación/restock) | parcial |

## 6. Tareas

- [x] Escribir pruebas de creación (`inventory can be created`).
- [x] Escribir prueba de índice accesible.
- [x] Escribir prueba de actualización de precio.
- [x] Escribir prueba de reposición de stock.
- [x] Escribir prueba de ajuste de stock.

## 7. Trazabilidad

| Requerimiento | Prueba |
|---|---|
| REQ-1.1 | `inventory can be created` |
| REQ-1.2 | `inventory index is accessible` |
| REQ-1.3 | `inventory price can be updated` |
| REQ-1.4 | `inventory restock updates stock` |
| REQ-1.5 | `inventory stock can be adjusted` |

## 8. Riesgos

- El modelo `Inventory` convive con el nuevo módulo `Product`; se recomienda migrar
  el inventario hacia `Product`/`Category` en una iteración futura de SDD.