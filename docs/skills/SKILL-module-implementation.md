# SKILL — Implementación de un módulo o requerimiento

## Descripción

Capacidad para llevar un requerimiento de AriaTechShop-ERP desde el *issue* hasta
el Pull Request, pasando por la especificación, el plan, las tareas, la
implementación y las pruebas. Aplica el flujo SDD adoptado en el PR #130.

## Cuándo usar

- Se crea un **issue** de funcionalidad nueva (feat), corrección (fix) o mejora.
- El requerimiento toca al menos uno de los módulos del ERP (Inventario,
  Ventas, Reparaciones, Productos/Categorías, Usuarios, Autenticación).

## Qué produce

1. **Spec** en `docs/specs/{modulo}.spec.md` usando [SPEC-TEMPLATE.md](../specs/SPEC-TEMPLATE.md).
2. **Plan** y **tareas** verificables dentro de la spec.
3. **Rama** con convención del repositorio (p. ej. `feat/`, `fix/`, `docs/`).
4. **Implementación** (backend Laravel y/o frontend Next.js según el caso).
5. **Tests** en Pest que cubran los criterios de aceptación.
6. **Pull Request** que referencia la spec y el issue (ver plantilla del repo).

## Procedimiento

### Paso 1 — Spec
- Analizar el requerimiento y redactarlo como **criterios de aceptación** (REQ-x.y).
- Copiar `docs/specs/SPEC-TEMPLATE.md` y completar resumen, contexto, dependencias
  y riesgos.

### Paso 2 — Plan y tareas
- Desglosar el desarrollo en fases P1..Pn y marcar cada una como pendiente/en curso/hecho.
- Toda tarea que implique lógica debe tener asociado al menos un **caso de prueba**.

### Paso 3 — Rama y commits
- Crear rama desde `main`: `git checkout -b feat/<id>-<descripcion>`.
- Commits atómicos siguiendo **Conventional Commits**: `feat:`, `fix:`, `test:`, `docs:`, `ci:`.

### Paso 4 — Implementación
- Seguir la arquitectura existente (controladores, modelos, `routes/api.php` o `routes/web.php`).
- Regla de seguridad: exponer en API pública únicamente lo necesario; el resto va
  dentro de `middleware('auth:sanctum')`.

### Paso 5 — Pruebas
- Escribir casos en `server/tests/Feature/Api/` (o Unit) siguiendo
  [SKILL-testing](./SKILL-testing.md).
- Ejecutar: `php artisan test` y confirmar el suite en verde.

### Paso 6 — Pull Request
- Llenar la plantilla del repositorio (`.github/PULL_REQUEST_TEMPLATE/`).
- Marcar `close(s) #<issue>` y vincular la spec.
- Verificar que **GitHub Actions** corra el test suite (`.github/workflows/test-suite.yml`).

## Validación del skill

- [ ] La spec existe con criterios de aceptación.
- [ ] El PR incluye tests que cubren todos los REQ.
- [ ] El suite completo pasa en verde en CI.
- [ ] El PR referencia spec e issue.