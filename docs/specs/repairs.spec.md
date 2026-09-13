---
id: RPR-001
title: Gestión de reparaciones del servicio técnico
status: in_progress
updated: 2026-09-12
owner: Brayan López Orcí
related_issue: null
tests: server/tests/Feature/Api/RepairApiTest.php
---

# Spec RPR-001 — Gestión de reparaciones del servicio técnico

## 1. Resumen

El sistema debe permitir registrar equipos de clientes para el servicio técnico,
llevar su historial de estados (pendiente, diagnosticado, aprobado, en reparación,
completado, entregado, cancelado), notificar por correo los cambios de estado y
asignar técnicos.

## 2. Requerimientos (criterios de aceptación)

- REQ-2.1 Se registra una reparación con **cliente**, **equipo** y **descripción del problema**; se genera el número de reparación secuencial (`RRP-00001`) y queda en estado `pending`.
- REQ-2.2 El registro valida los datos obligatorios y el formato de email (de lo contrario → `422`).
- REQ-2.3 Se puede **listar** reparaciones y **filtrarlas** por estado o búsqueda.
- REQ-2.4 Se puede **consultar el detalle** de una reparación.
- REQ-2.5 Se puede **cambiar el estado** registrando el historial y notificando al cliente.
- REQ-2.6 Se puede **enviar encuesta** de satisfacción al cliente.
- REQ-2.7 Se genera el **historial de estados** (`repair_status_histories`).

## 3. Contexto

- Backend Laravel 12, controlador `RepairController` (`routes/api.php` bajo `/api/repairs`).
- Integración de correos con Resend vía `EmailApiService`.
- Post-condición de seguridad: **pendiente** aplicar `auth:sanctum` a estos endpoints (ver issue #103).

## 4. Dependencias

- `EmailApiService` (Resend). En pruebas se mockea.
- Tablas `repairs` y `repair_status_histories`.

## 5. Plan

| Fase | Descripción | Estado |
|---|---|---|
| P1 | Cobertura de registro, validación y numeración | ✅ |
| P2 | Cobertura de listado y filtros | ✅ |
| P3 | Cambio de estado + historial + correo | ⏳ pendiente |
| P4 | Encuesta + seguridad de endpoints | ⏳ pendiente |

## 6. Tareas

- [x] `se puede registrar una reparación válida` (TC-011).
- [x] `registro de reparación valida los datos obligatorios` (TC-012).
- [x] `el número de reparación se genera de forma secuencial` (TC-013).
- [x] `se puede listar reparaciones` (TC-014).
- [x] `las reparaciones se pueden filtrar por estado` (TC-015).
- [ ] Test cambio de estado y registro de historial.
- [ ] Test de notificación por correo (aserciones sobre el mock).
- [ ] Test de autorización (`401` sin token).

## 7. Trazabilidad

| Requerimiento | Prueba |
|---|---|
| REQ-2.1 | `se puede registrar una reparación válida`, `el número de reparación se genera de forma secuencial` |
| REQ-2.2 | `registro de reparación valida los datos obligatorios` |
| REQ-2.3 | `se puede listar reparaciones`, `las reparaciones se pueden filtrar por estado` |
| REQ-2.5, 2.6 | sin prueba aún (fase P3/P4) |

## 8. Riesgos

- Envío de correos depende de una API externa (Resend) → mantener mock en pruebas.
- Endpoints públicos; sin autenticación se expone información sensible del cliente (issue #103).