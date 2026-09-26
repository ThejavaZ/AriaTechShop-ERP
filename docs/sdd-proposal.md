# Propuesta de Spec-Driven Development para AriaTechShop-ERP

## 1. Introducción

El proyecto **AriaTechShop-ERP** es una aplicación web orientada a la administración de una tienda de productos tecnológicos y servicios de reparación.

El proyecto cuenta actualmente con un backend desarrollado con Laravel y un frontend desarrollado con Next.js. Durante la etapa de ingeniería inversa se identificaron módulos relacionados con autenticación, usuarios, productos, categorías, inventario, ventas, reparaciones y notificaciones.

Como siguiente etapa del proyecto se propone incorporar una metodología de **Spec-Driven Development (SDD)** para mejorar la forma en que se definen, implementan y validan nuevas funcionalidades.

La propuesta busca establecer una relación clara entre los requerimientos del sistema, las especificaciones, las tareas de desarrollo, la implementación y las pruebas.

---

# 2. Objetivo

Implementar un flujo de trabajo basado en Spec-Driven Development que permita desarrollar nuevas funcionalidades del proyecto a partir de especificaciones claras y verificables.

Los objetivos específicos son:

* definir los requerimientos antes de comenzar la implementación;
* documentar el comportamiento esperado de cada funcionalidad;
* dividir las especificaciones en tareas técnicas;
* mantener trazabilidad entre requerimientos, código y pruebas;
* reducir ambigüedades durante el desarrollo;
* facilitar la revisión de Pull Requests;
* utilizar las especificaciones como referencia para pruebas automatizadas;
* establecer una base reutilizable para futuras funcionalidades.

---

# 3. Situación actual del proyecto

La ingeniería inversa realizada previamente permitió identificar el estado actual del sistema y establecer una línea base.

Actualmente el proyecto cuenta con:

* Backend Laravel 12.
* Frontend Next.js 16 y React 19.
* API REST.
* Autenticación mediante Laravel Sanctum.
* Componentes Livewire.
* Gestión de productos y categorías.
* Gestión de inventario.
* Gestión de ventas.
* Gestión de reparaciones.
* Sistema de notificaciones por correo.
* Estructura de pruebas automatizadas configurada.

Sin embargo, también se identificaron funcionalidades parciales y áreas de mejora.

Entre ellas:

* métodos de controladores sin implementación completa;
* diferencias entre algunas rutas y las operaciones realmente implementadas;
* ausencia de casos de prueba automatizados en `Feature` y `Unit`;
* diferentes niveles de madurez entre módulos;
* necesidad de establecer una trazabilidad más clara entre requerimientos, implementación y pruebas.

Por estas razones, SDD se propone como una metodología para organizar el desarrollo futuro sin alterar innecesariamente la funcionalidad existente.

---

# 4. ¿Qué es Spec-Driven Development?

**Spec-Driven Development (SDD)** es un enfoque de desarrollo en el que las especificaciones de una funcionalidad se definen antes de realizar su implementación.

En lugar de comenzar directamente modificando código, el proceso parte de una descripción clara de:

* qué problema se quiere resolver;
* qué comportamiento debe tener el sistema;
* cuáles son las reglas de negocio;
* cuáles son los criterios de aceptación;
* qué restricciones técnicas deben respetarse.

Posteriormente, la especificación se utiliza para generar o definir las tareas necesarias para realizar la implementación.

El flujo propuesto es:

```text
Requerimiento
      ↓
Especificación
      ↓
Criterios de aceptación
      ↓
Tareas técnicas
      ↓
Implementación
      ↓
Pruebas
      ↓
Revisión
      ↓
Pull Request
```

Esto permite que el código desarrollado tenga una referencia explícita respecto al comportamiento esperado.

---

# 5. Comparación entre Kiro y Spec Kit

Para seleccionar una herramienta apropiada para el proyecto se consideraron dos alternativas relacionadas con el desarrollo orientado por especificaciones: **Kiro** y **Spec Kit**.

## 5.1 Kiro

Kiro es un entorno de desarrollo orientado a especificaciones que busca estructurar el trabajo de desarrollo mediante elementos como:

* requisitos;
* diseño;
* tareas;
* implementación.

Su enfoque busca reducir la distancia entre la intención de una funcionalidad y su implementación técnica.

### Ventajas

* Integra el flujo de especificación dentro del entorno de desarrollo.
* Permite trabajar con requisitos y tareas de manera estructurada.
* Facilita un flujo orientado a funcionalidades.
* Puede ser útil para proyectos que adopten su entorno de trabajo.

### Consideraciones

* Está más ligado a su propio entorno y flujo de desarrollo.
* La adopción del proceso puede requerir adaptar el flujo de trabajo existente del equipo.
* Para un repositorio académico que ya utiliza GitHub y múltiples herramientas, puede representar una dependencia adicional.

---

# 6. Spec Kit

**Spec Kit** es una herramienta orientada a implementar un flujo de Spec-Driven Development sobre un repositorio existente.

El enfoque permite trabajar con elementos como:

* constitución o reglas del proyecto;
* especificaciones;
* planes de implementación;
* tareas;
* documentación;
* trazabilidad.

Su principal ventaja para este proyecto es que permite mantener las especificaciones como archivos dentro del propio repositorio.

Una estructura conceptual puede ser:

```text
Constitución
    ↓
Especificación
    ↓
Plan
    ↓
Tasks
    ↓
Implementación
    ↓
Pruebas
```

---

# 7. Comparación

| Criterio                                 | Kiro     | Spec Kit |
| ---------------------------------------- | -------- | -------- |
| Orientación a SDD                        | Sí       | Sí       |
| Especificaciones antes del código        | Sí       | Sí       |
| Requisitos estructurados                 | Sí       | Sí       |
| Generación/organización de tareas        | Sí       | Sí       |
| Integración con repositorio existente    | Posible  | Adecuada |
| Documentación como parte del repositorio | Sí       | Sí       |
| Adaptación a flujo Git/GitHub            | Posible  | Adecuada |
| Uso en proyecto académico                | Adecuado | Adecuado |
| Facilidad para demostrar trazabilidad    | Adecuada | Alta     |
| Integración con un proyecto existente    | Buena    | Buena    |
| Dependencia de un entorno específico     | Mayor    | Menor    |

---

# 8. Herramienta seleccionada

Para AriaTechShop-ERP se propone utilizar **Spec Kit** como herramienta principal para implementar el flujo SDD.

La decisión se basa principalmente en que el proyecto ya cuenta con un repositorio Git y un flujo de trabajo basado en Issues, ramas y Pull Requests.

Spec Kit permite mantener las especificaciones como parte del repositorio, lo que facilita relacionarlas con:

* Issues;
* ramas;
* commits;
* Pull Requests;
* pruebas;
* documentación.

Esto permite que la especificación forme parte del historial del proyecto y pueda ser revisada junto con los cambios de código.

---

# 9. Justificación de la selección

La selección de Spec Kit se fundamenta en los siguientes puntos.

## 9.1 Integración con el repositorio existente

AriaTechShop-ERP ya utiliza Git y GitHub como mecanismo de control de versiones.

Por lo tanto, mantener las especificaciones dentro del repositorio permite conservar:

```text
Código
Documentación
Especificaciones
Tareas
Pruebas
Historial de cambios
```

en un mismo flujo de trabajo.

---

## 9.2 Trazabilidad

Una de las necesidades identificadas durante la ingeniería inversa es mejorar la relación entre funcionalidades y archivos del sistema.

Con SDD se busca establecer una relación como:

```text
Issue
  ↓
Specification
  ↓
Plan
  ↓
Tasks
  ↓
Commit
  ↓
Pull Request
  ↓
Tests
```

Esto permite conocer por qué se realizó un cambio y qué requerimiento intenta satisfacer.

---

## 9.3 Desarrollo incremental

El proyecto contiene módulos con diferentes niveles de madurez.

Por esta razón, no se propone aplicar SDD mediante una reescritura completa del sistema.

En cambio, se aplicará inicialmente a módulos seleccionados como pilotos y posteriormente se evaluará su adopción para nuevas funcionalidades.

---

## 9.4 Compatibilidad con el proyecto existente

El objetivo de SDD no será reemplazar Laravel, Next.js, Livewire, React ni las herramientas existentes.

La metodología se utilizará como una capa de organización del proceso de desarrollo.

La arquitectura tecnológica existente se mantiene como línea base.

---

# 10. Flujo SDD propuesto

El flujo de trabajo para nuevas funcionalidades será:

## Paso 1 — Identificación de la necesidad

La nueva funcionalidad se registra mediante un Issue de GitHub.

El Issue debe explicar:

* problema;
* objetivo;
* alcance;
* restricciones conocidas.

---

## Paso 2 — Creación de la especificación

Antes de modificar código se crea la especificación correspondiente.

La especificación debe definir:

* objetivo;
* actores involucrados;
* comportamiento esperado;
* reglas de negocio;
* escenarios;
* criterios de aceptación;
* restricciones;
* consideraciones técnicas relevantes.

---

## Paso 3 — Plan de implementación

Una vez aprobada la especificación se determina cómo se implementará.

El plan identifica:

* archivos que podrían modificarse;
* componentes involucrados;
* modelos;
* controladores;
* rutas;
* base de datos;
* pruebas necesarias.

---

## Paso 4 — Generación de tareas

El trabajo se divide en tareas pequeñas y verificables.

Ejemplo:

```text
Task 1 — Crear migración
Task 2 — Actualizar modelo
Task 3 — Implementar lógica de negocio
Task 4 — Crear endpoint
Task 5 — Actualizar interfaz
Task 6 — Crear pruebas
```

---

## Paso 5 — Implementación

Se crea una rama específica para la funcionalidad.

Ejemplo:

```text
sdd/inventory-restock
```

La implementación se realiza siguiendo la especificación y el plan definidos previamente.

---

## Paso 6 — Pruebas

Se desarrollan pruebas relacionadas con los criterios de aceptación.

Dependiendo de la funcionalidad pueden incluirse:

* pruebas unitarias;
* pruebas de integración;
* pruebas funcionales;
* pruebas E2E.

---

## Paso 7 — Pull Request

La rama se integra mediante un Pull Request.

El PR debe relacionarse con el Issue correspondiente y proporcionar evidencia de:

* implementación;
* pruebas;
* cumplimiento de la especificación.

Ejemplo:

```text
Closes #XX
```

---

## Paso 8 — Revisión y merge

El equipo revisa:

* cumplimiento de la especificación;
* calidad de la implementación;
* pruebas;
* posibles efectos secundarios;
* documentación.

Después de la aprobación se realiza el merge a la rama de integración correspondiente.

---

# 11. Estructura propuesta para SDD

Como base para los siguientes entregables se propone organizar la documentación de SDD de la siguiente manera:

```text
docs/
├── reverse-engineering.md
├── er-diagram.md
├── traceability.md
├── sdd-proposal.md
├── sdd-implementation.md
└── spec-kit-installation.md
```

Las especificaciones y tareas de los pilotos se organizarán posteriormente de acuerdo con la estructura establecida por Spec Kit.

---

# 12. Módulos piloto

A partir de la ingeniería inversa se seleccionaron tres módulos para probar el proceso SDD.

## 12.1 Inventario

### Motivo de selección

El módulo de inventario contiene varias operaciones independientes y reglas que pueden expresarse claramente como requisitos.

Actualmente se identificaron operaciones de:

* consulta;
* alta;
* reabastecimiento;
* ajuste de existencias;
* actualización de precio.

### Objetivo del piloto

Utilizar SDD para definir y desarrollar una mejora del módulo de inventario manteniendo trazabilidad entre la especificación, las tareas, la implementación y las pruebas.

---

## 12.2 Reparaciones

### Motivo de selección

El módulo de reparaciones contiene un flujo de negocio más complejo.

Incluye:

* registro;
* diagnóstico;
* aprobación;
* reparación;
* finalización;
* entrega;
* cancelación;
* historial de estados;
* asignación de técnico;
* notificaciones;
* encuesta.

### Objetivo del piloto

Utilizar SDD para documentar formalmente las reglas del flujo de estados y validar que cada transición tenga un comportamiento definido y comprobable.

---

## 12.3 Productos y categorías

### Motivo de selección

Productos y categorías representan una parte central del catálogo de la aplicación y permiten trabajar con relaciones entre entidades, estados, stock y categorías.

### Objetivo del piloto

Definir mediante SDD las reglas necesarias para administrar y consultar productos y sus categorías, manteniendo consistencia entre backend, API y frontend.

---

# 13. Estrategia de adopción

La adopción de SDD se realizará de forma incremental.

No se pretende convertir todo el proyecto existente de manera inmediata.

La estrategia será:

```text
Estado actual
     ↓
Selección de módulo piloto
     ↓
Especificación
     ↓
Plan
     ↓
Tasks
     ↓
Implementación
     ↓
Pruebas
     ↓
Pull Request
     ↓
Evaluación
     ↓
Ajustes al proceso
     ↓
Aplicación a nuevos módulos
```

Los pilotos permitirán evaluar si la metodología facilita:

* la definición de requerimientos;
* la planeación;
* la implementación;
* la revisión;
* las pruebas;
* la trazabilidad.

---

# 14. Relación con GitHub

El proceso SDD se integrará con el flujo de control de versiones utilizado en el proyecto.

La relación propuesta es:

| Elemento SDD   | GitHub                      |
| -------------- | --------------------------- |
| Necesidad      | Issue                       |
| Especificación | Archivo/documentación       |
| Plan           | Documento de implementación |
| Task           | Task/Issue/checklist        |
| Implementación | Branch                      |
| Cambio         | Commit                      |
| Revisión       | Pull Request                |
| Validación     | Tests / CI                  |
| Integración    | Merge                       |

Esto permite mantener evidencia del proceso completo.

---

# 15. Criterios para considerar exitoso un piloto

Un piloto SDD se considerará exitoso cuando:

1. La funcionalidad tenga una especificación clara.
2. Los criterios de aceptación sean verificables.
3. Exista un plan de implementación.
4. Las tareas estén relacionadas con el plan.
5. La implementación corresponda con la especificación.
6. Existan pruebas asociadas a los criterios de aceptación.
7. El trabajo esté relacionado con un Issue.
8. El código se integre mediante Pull Request.
9. La documentación permita reconstruir la relación entre requerimiento y código.
10. Las lecciones aprendidas puedan utilizarse para los siguientes módulos.

---

# 16. Riesgos y consideraciones

La adopción de SDD también presenta algunos riesgos.

### Sobrecarga documental

Una especificación demasiado extensa puede aumentar el tiempo de desarrollo sin aportar suficiente valor.

**Medida:** mantener las especificaciones enfocadas en comportamiento, reglas y criterios de aceptación.

### Especificaciones desactualizadas

Si el código cambia y la especificación no se actualiza, se pierde la trazabilidad.

**Medida:** actualizar la especificación como parte del mismo flujo de cambios.

### Aplicación excesiva al código existente

Intentar documentar o reestructurar todo el sistema existente antes de desarrollar nuevas funcionalidades puede retrasar el proyecto.

**Medida:** utilizar la ingeniería inversa como línea base y aplicar SDD principalmente a cambios nuevos o módulos piloto.

### Dependencia de la herramienta

La herramienta no debe convertirse en el objetivo del proceso.

**Medida:** considerar SDD como la metodología y Spec Kit como una herramienta para facilitar su aplicación.

---

# 17. Resultado esperado

Al finalizar la implementación de los pilotos se espera contar con un flujo reproducible para desarrollar nuevas funcionalidades:

```text
Requerimiento
      ↓
Issue
      ↓
Specification
      ↓
Plan
      ↓
Tasks
      ↓
Branch
      ↓
Implementación
      ↓
Tests
      ↓
Pull Request
      ↓
Review
      ↓
Merge
```

De esta manera, cada cambio importante tendrá una justificación y una referencia documental que permita conocer:

* qué se solicitó;
* qué se especificó;
* qué se implementó;
* qué se probó;
* cómo se integró al proyecto.

---

# 18. Conclusión

La incorporación de Spec-Driven Development permitirá establecer un proceso más estructurado para el desarrollo de nuevas funcionalidades de AriaTechShop-ERP.

La selección de Spec Kit se considera adecuada para el proyecto debido a su orientación hacia especificaciones mantenidas junto con el repositorio y a su compatibilidad con un flujo basado en GitHub, Issues, ramas y Pull Requests.

La metodología se aplicará inicialmente mediante tres pilotos:

1. Inventario.
2. Reparaciones.
3. Productos y categorías.

Estos pilotos permitirán validar el proceso antes de extenderlo a otros módulos del sistema.

La propuesta no busca modificar la arquitectura tecnológica actual, sino establecer una metodología que permita conectar los requerimientos con la implementación y las pruebas de forma trazable y verificable.
