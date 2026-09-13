---
id: AUT-001
title: Autenticación de clientes vía API (Sanctum)
status: in_progress
updated: 2026-09-12
owner: Javier Armando Sarmiento Gil
related_issue: null
tests: server/tests/Feature/Api/AuthApiTest.php
---

# Spec AUT-001 — Autenticación de clientes vía API (Sanctum)

## 1. Resumen

El frontend de Next.js requiere que los clientes se registren e inicien sesión contra
la API Laravel, obteniendo un token `Bearer` de Sanctum para las rutas protegidas.

## 2. Requerimientos (criterios de aceptación)

- REQ-4.1 `POST /api/register` crea el usuario y responde `201` con `message` y `user`.
- REQ-4.2 El registro valida la fortaleza de la contraseña (mín. 8, letras, mayúsculas/minúsculas, números, símbolos) → `422` en caso contrario.
- REQ-4.3 `POST /api/login` responde `200` para credenciales válidas y `401` para inválidas. *(Nota: la respuesta con `access_token` en texto plano es el objetivo del PR #104, aún sin merge a `main` — hallazgo H-7.)*
- REQ-4.4 El mecanismo de tokens Sanctum genera tokens en texto plano que el cliente usa en `Authorization: Bearer`.
- REQ-4.5 (Futuro) `POST /api/logout` revoca el token actual. **Nota:** el controlador `AuthController::logout` existe pero la ruta no está registrada (H-6).

## 3. Contexto

- `App\Http\Controllers\api\AuthController` (login, register, logout).
- Tokens `personal_access_tokens` de Sanctum.
- Bug corregido recientemente en rama relacionada #104: devolver el token en texto plano para que el cliente HTTP adjunte el encabezado `Authorization`.

## 4. Dependencias

- Laravel Sanctum, tabla `personal_access_tokens`.

## 5. Plan

| Fase | Descripción | Estado |
|---|---|---|
| P1 | Registro y login | ✅ |
| P2 | Logout y revocación de token | ⏳ pendiente (falta ruta) |
| P3 | Refresh token / expiración | ⏳ futuro |

## 6. Tareas

- [x] `register de usuario retorna 201 con el usuario` (TC-001).
- [x] `register rechaza password debil` (TC-002).
- [x] `login retorna 200 con credenciales válidas` (TC-003).
- [x] `login rechaza credenciales incorrectas` (TC-004).
- [x] `un usuario genera token de acceso Sanctum en texto plano` (TC-004b).
- [ ] Al mergear PR #104: aserciones de `access_token` en respuesta HTTP.
- [ ] Registrar `POST /api/logout` y test de revocación.

## 7. Trazabilidad

| Requerimiento | Prueba |
|---|---|
| REQ-4.1 | `register de usuario retorna 201 con el usuario` |
| REQ-4.2 | `register rechaza password debil` |
| REQ-4.3 | `login retorna 200 con credenciales válidas`, `login rechaza credenciales incorrectas` |
| REQ-4.4 | `un usuario genera token de acceso Sanctum en texto plano` |
| REQ-4.5 | sin prueba aún (ruta pendiente) |

## 8. Riesgos

- Si no se registra `/api/logout`, los tokens no se pueden revocar por el cliente (H-6).
- El password debe conservar la política de seguridad actual (tarjeta de seguridad).