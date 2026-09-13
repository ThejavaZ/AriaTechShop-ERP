---
id: PRD-001
title: Catálogo de productos y categorías
status: stable
updated: 2026-09-12
owner: Laura Jacqueline Dávila Villa
related_issue: null
tests: server/tests/Feature/Api/CatalogApiTest.php
---

# Spec PRD-001 — Catálogo de productos y categorías

## 1. Resumen

El catálogo público debe exponer via API los productos activos (con su categoría)
y las categorías activas para alimentar el frontend de Next.js (`client/`).

## 2. Requerimientos (criterios de aceptación)

- REQ-3.1 `GET /api/products` lista únicamente productos **activos** (`is_active=true`).
- REQ-3.2 El listado permite **filtrar por categoría** (`?category_id=`).
- REQ-3.3 `GET /api/products/{slug}` devuelve el detalle con su categoría; si el slug no existe → `404`.
- REQ-3.4 `GET /api/categories` lista únicamente **categorías activas**.
- REQ-3.5 El catálogo es **público** (no requiere autenticación).

## 3. Contexto

- Backend Laravel 12: `routes/api.php`, controladores `Api\ProductController` y `Api\CategoryController`.
- Frontend Next.js consume estos endpoints.

## 4. Dependencias

- Tablas `categories` y `products`.

## 5. Plan

| Fase | Descripción | Estado |
|---|---|---|
| P1 | Cobertura del catálogo público | ✅ |
| P2 | CRUD administrativo de productos/categorías | ⏳ (requerimiento futuro) |
| P3 | Sincronización de stock con inventario | ⏳ (requerimiento futuro) |

## 6. Tareas

- [x] `el catálogo público lista productos activos` (TC-005).
- [x] `el catálogo excluye productos inactivos` (TC-006).
- [x] `el catálogo filtra productos por categoría` (TC-007).
- [x] `se muestra un producto por su slug` (TC-008).
- [x] `un slug inexistente devuelve 404` (TC-009).
- [x] `el catálogo público devuelve categorías activas` (TC-010).

## 7. Trazabilidad

| Requerimiento | Prueba |
|---|---|
| REQ-3.1 | `el catálogo público lista productos activos` |
| REQ-3.2 | `el catálogo filtra productos por categoría` |
| REQ-3.3 | `se muestra un producto por su slug`, `un slug inexistente devuelve 404` |
| REQ-3.4 | `el catálogo público devuelve categorías activas` |
| REQ-3.5 | Los 6 casos del archivo (endpoints públicos sin token) |

## 8. Riesgos

- No existen factories para `Product`/`Category`; las pruebas crean registros
  directamente con el modelo. Se recomienda agregar factories en una iteración futura.