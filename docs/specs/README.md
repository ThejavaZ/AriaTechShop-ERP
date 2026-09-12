# Specs — Spec-Driven Development

Especificaciones de módulos piloto de AriaTechShop-ERP conforme al flujo SDD
propuesto en el PR #130: **requerimiento → especificación → plan → tareas →
implementación → pruebas → Pull Request**.

Cada spec sigue el formato de Spec Kit (Markdown con *front matter* YAML) para
mantener trazabilidad entre los requerimientos, el código y las pruebas.

## Índice de specs

| Spec | Módulo | Estado | Pruebas asociadas |
|---|---|---|---|
| [INV-001](./inventory.spec.md) | Inventario | Estable | `tests/Feature/InventoryTest.php` |
| [RPR-001](./repairs.spec.md) | Reparaciones | En desarrollo | `tests/Feature/Api/RepairApiTest.php` |
| [PRD-001](./products-categories.spec.md) | Productos / Categorías | Estable | `tests/Feature/Api/CatalogApiTest.php` |
| [AUT-001](./authentication.spec.md) | Autenticación API | En desarrollo | `tests/Feature/Api/AuthApiTest.php` |

## Plantilla

Para nuevos módulos o requerimientos, replicar [SPEC-TEMPLATE.md](./SPEC-TEMPLATE.md).

## Flujo sugerido

1. Crear un **issue** por requerimiento.
2. Crear la **spec** en `docs/specs/` con criterios de aceptación.
3. Elaborar el **plan** y las **tareas** de la spec.
4. Implementar en una **rama** por spec.
5. Escribir las **pruebas** (Pest) cubriendo la spec.
6. Abrir **Pull Request** referenciando la spec y el issue.