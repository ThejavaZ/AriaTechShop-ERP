# Plan de Pruebas — AriaTechShop-ERP

**Universidad Tecnológica de Hermosillo**
**Ingeniería en Desarrollo y Gestión de Software**
**Gestión del proceso de desarrollo de Software — Prof. Iván Chenoweth**

Grupo 10-2 — Integrantes:
- Javier Armando Sarmiento Gil
- Brayan López Orcí
- Laura Jacqueline Dávila Villa
- Ramón Viera Salas

Hermosillo, Sonora, México — 12 de Septiembre de 2026

---

## 1. Objetivo

Definir y ejecutar un plan de pruebas automatizadas para el módulo de negocio
de AriaTechShop-ERP, integrado al flujo **Spec-Driven Development (SDD)** que se
impulsó en la propuesta documentada en el PR #130. El objetivo es:

1. Documentar el plan de pruebas del proyecto.
2. Ejecutar el **test suite** con una herramienta de pruebas automáticas (Pest sobre PHPUnit).
3. Publicar un **PR mínimo** que entregue los *skills* y *specs* (especificaciones)
   para nuevos módulos o requerimientos, con sus casos de prueba asociados.

> Línea base: análisis de ingeniería inversa (PR #128) y propuesta de adopción de
> SDD (PR #130), realizados por Dávila Villa Laura Jacqueline (`@a23311069`).

---

## 2. Alcance

| Alcance | Descripción |
|---|---|
| Backend | API Laravel 12 en `server/` (Sanctum, modelos, controladores de API) |
| Módulos piloto SDD | **Inventario**, **Reparaciones**, **Productos/Categorías** |
| Autenticación API | Login / Registro con tokens Sanctum |
| Frontend | **Fuera de alcance** en esta iteración (Next.js en `client/`) |
| Herramienta | Pest 3 + PHPUnit 11, base de datos SQLite en memoria |

---

## 3. Herramienta de pruebas automáticas

### 3.1 Selección

Se utiliza **Pest** (framework de testing sobre PHPUnit) porque:
- Es el estándar de facto en ecosistemas Laravel (proyecto base del equipo).
- Sintaxis de funciones (`test()`, `it()`) más legible y alineada a *specs*.
- Compatible con PHPUnit 11, el cual ya era dependencia del proyecto.
- Se integra a CI/CD (GitHub Actions) sin configuración adicional.

### 3.2 Instalación

```bash
cd server
composer require pestphp/pest --dev --with-all-dependencies
```

> **Hallazgo del diagnóstico:** los tests del repositorio usaban sintaxis de Pest
> (`tests/Pest.php`, `test()`), pero **Pest no estaba declarado** en `composer.json`.
> La suite no era ejecutable. Este PR corrige la dependencia en `require-dev`.

### 3.3 Configuración

- `server/phpunit.xml`: define los suites `Unit` y `Feature`, usa `DB_CONNECTION=sqlite` con `DB_DATABASE=:memory:` para pruebas aisladas y rápidas.
- `server/tests/Pest.php`: vincula los tests de `Feature` a `Tests\TestCase` con `RefreshDatabase` (migraciones en memoria por cada ejecución).
- `server/composer.json`: se agregó `"pestphp/pest": "^3.8"` a `require-dev`.

---

## 4. Estrategia de pruebas

1. **Pruebas Unitarias**: lógica pura de modelos/helpers (p. ej. generación secuencial del número de reparación `RRP-00001`).
2. **Pruebas de Feature / API**: ejercitan las rutas HTTP reales (`/api/...`) contra la base en memoria, validando respuestas JSON, códigos de estado, persistencia y reglas de validación.
3. **Aislamiento**: cada test ejecuta migraciones desde cero (`RefreshDatabase`).
4. **Servicios externos**: el envío de correos (Resend `EmailApiService`) se **mockea** para que las pruebas sean herméticas y reproducibles sin red.
5. **CI/CD**: el suite se ejecuta automáticamente en GitHub Actions sobre cada PR/merge a `main` (ver `.github/workflows/test-suite.yml`).

---

## 5. Casos de prueba

| ID | Módulo | Caso | Escenario | Resultado esperado |
|---|---|---|---|---|
| TC-001 | Autenticación API | Registro exitoso | `POST /api/register` con datos válidos | `201`, usuario creado |
| TC-002 | Autenticación API | Registro con contraseña débil | password < 8 chars, sin símbolos/números | `422` |
| TC-003 | Autenticación API | Login exitoso | `POST /api/login` credenciales válidas | `200`, sesión iniciada |
| TC-004 | Autenticación API | Login con credenciales incorrectas | password erróneo | `401` |
| TC-004b | Autenticación API | Generación de token Sanctum | `createToken('auth_token')->plainTextToken` | token en texto plano (mecanismo del fix #104) |
| TC-005 | Productos | Catálogo público lista activos | `GET /api/products` | `200`, lista de activos |
| TC-006 | Productos | Excluye productos inactivos | producto `is_active=false` | listado vacío para ese ítem |
| TC-007 | Productos | Filtrar por categoría | `?category_id=X` | solo productos de la categoría |
| TC-008 | Productos | Detalle por slug | `GET /api/products/{slug}` | `200` con datos |
| TC-009 | Productos | Slug inexistente | slug aleatorio | `404` |
| TC-010 | Categorías | Listado público activas | `GET /api/categories` | `200`, solo `is_active=true` |
| TC-011 | Reparaciones | Registro válido | `POST /api/repairs` con datos obligatorios | `201`, estado `pending` |
| TC-012 | Reparaciones | Validación de datos | campos faltantes / email inválido | `422` |
| TC-013 | Reparaciones | Número secuencial | existe `RRP-00042` | siguiente `RRP-00043` |
| TC-014 | Reparaciones | Listado | `GET /api/repairs` varias reparaciones | `200`, todas |
| TC-015 | Reparaciones | Filtro por estado | `?status=pending` | solo pendientes |
| TC-016 | Inventario | Creación | `POST /inventory` autenticado | redirige, registro en BD |
| TC-017 | Inventario | Índice accesible | `GET /inventory` autenticado | `200`, vista con productos |
| TC-018 | Inventario | Actualizar precio | `PATCH /inventory/{id}/price` | precio nuevo persistido |
| TC-019 | Inventario | Reposición (restock) | restock de producto | stock actualizado |
| TC-020 | Inventario | Ajuste de stock | ajuste manual | stock actualizado |

Los casos TC-001 a TC-015 (más TC-004b) corresponden a la nueva suite API en `server/tests/Feature/Api/`
y los TC-016 a TC-020 a la suite existente de inventario (`server/tests/Feature/InventoryTest.php`).

---

## 6. Hallazgos del diagnóstico

| # | Hallazgo | Evidencia | Estado en este PR |
|---|---|---|---|
| H-1 | Pest no estaba instalado como dependencia | `composer.json` sin `pestphp/pest` pese al uso de sintaxis Pest | ✅ Se instala en `require-dev` |
| H-2 | Tests "starter" de Breeze obsoletos | `tests/Feature/Auth/*`, `ProfileTest`, `ExampleTest` apuntan a rutas web (`/login`, `/profile`, `/register`) inexistentes → `404` | ✅ Se eliminan (documentado) |
| H-3 | Ausencia de casos de prueba de API | Diagnóstico del PR #128: "ausencia de casos significativos en Feature/Unit" | ✅ Se agregan 16 casos (TC-001..TC-015, TC-004b) |
| H-4 | Servicios externos sin mock | El registro de reparación lanza HTTP hacia Resend | ✅ `EmailApiService` se mockea |
| H-5 | Endpoints de reparaciones y notificaciones sin autenticación | Rutas `api.php` fuera de `auth:sanctum` | ⏳ Pendiente (ver issue #103) |
| H-6 | No existe `POST /api/logout` | `AuthController::logout` sin ruta registrada | ⏳ Pendiente como requerimiento futuro |
| H-7 | El login/register aún no devuelve `access_token` en `main` | El fix está en el PR #104 (`devolver access_token de Sanctum en login/register y adjuntar Authorization Bearer`) | ⏳ Aserciones de token se habilitarán al mergear #104 |

---

## 7. Resultados de la ejecución

| Ejecución | Test ejecutados | Resultado |
|---|---|---|
| Línea base (antes del PR) | — | Suite **no ejecutable** (Pest ausente) |
| Tras instalar Pest (sin cambios) | 30 | **7 pasan / 23 fallan** |
| Con este PR | 22 | **22 pasan / 0 fallan** (51 assertions) |

Ver detalle en [`docs/test-suite-report.md`](./test-suite-report.md).

---

## 8. Cómo ejecutar la suite

```bash
cd server
composer install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan test                      # suite completa
php artisan test tests/Feature/Api    # solo la nueva suite de API
php artisan test --log-junit=tests-report/junit.xml   # genera reporte JUnit
```

---

## 9. Relación con SDD

Este plan forma parte del flujo **requerimiento → especificación → plan → tareas →
implementación → pruebas → Pull Request** propuesto en el PR #130. Las especificaciones
de los módulos piloto y los *skills* del equipo se publican junto con este plan en:

- [`docs/specs/`](./specs/) — Specs de Inventario, Reparaciones y Productos/Categorías.
- [`docs/skills/`](./skills/) — Skills para la implementación de nuevos módulos/requerimientos.