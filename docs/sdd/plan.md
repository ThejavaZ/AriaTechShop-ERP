# Plan del proyecto — Unidad 3: CI/CD, Monitoreo, Trazabilidad y Auditoría

## Objetivo
Extender el flujo de trabajo de CI/CD del proyecto AriaTechShop-ERP para
cubrir la liberación y el despliegue continuo de la aplicación,
incorporando monitoreo, trazabilidad, auditoría y un módulo adicional
de seguridad.

## Alcance
- Complementar el pipeline de GitHub Actions con etapas de liberación
  y despliegue.
- Definir el entorno de liberación (staging) y sus scripts.
- Definir los niveles de servicio acordados (SLA).
- Instalar y configurar un servidor de monitoreo con alarmas y alertas.
- Implementar logs y tracers para trazabilidad de solicitudes.
- Implementar un visor de auditoría de acciones del sistema.
- Integrar Snyk como módulo adicional de análisis de seguridad.

## Módulos piloto
1. Pipeline CI/CD y entorno de liberación
2. Monitoreo (SLA + servidor de métricas + alarmas)
3. Trazabilidad y Auditoría (logs, tracers, visor de auditoría)

## Responsables
| Módulo                          | Responsable |
|----------------------------------|-------------|
| SDD, CI/CD, Seguridad (Snyk)      | Dávila Villa Laura Jacqueline |
| SLA y Monitoreo                   | López Orcí Brayan    |
| Trazabilidad                      | Sarmiento Gil Javier Armando |
| Auditoría                         | Viera Salas Ramón     |

## Flujo de trabajo
Requerimiento → Especificación → Plan → Tareas → Implementación →
Pruebas → Pull Request → Evidencia