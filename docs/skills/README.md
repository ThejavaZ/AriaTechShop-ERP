# Skills — Capacidades para nuevos módulos y requerimientos

En el marco de **Spec-Driven Development (SDD)**, un *skill* es una capacidad
reproducible que el equipo aplica al enfrentarse a un nuevo módulo o requerimiento.
Cada skill define *cuándo usarla*, *qué produce* y *cómo validarla*, garantizando
que cualquier integrante del grupo entregue el mismo estándar: **spec → plan →
tareas → código → pruebas → PR**.

## Índice de skills

| Skill | Cuándo se usa | Qué arroja |
|---|---|---|
| [Implementación de módulo](./SKILL-module-implementation.md) | Nuevo módulo o requerimiento | Spec, plan, tareas, rama, tests, PR |
| [Pruebas automáticas (Pest)](./SKILL-testing.md) | Escribir/ejecutar el test suite | Tests herméticos + reporte JUnit |

## Cómo usar un skill

1. Al crear un **issue** de requerimiento, el responsable abre la skill correspondiente.
2. La skill guía la creación de la **spec** (`docs/specs/`) y sus **tareas**.
3. Al terminar, el PR referencia la spec, el issue y el reporte del test suite.