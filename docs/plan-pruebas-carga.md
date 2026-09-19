# Plan de implementación — Pruebas de carga con K6

## Objetivo
Medir los tiempos de respuesta de los endpoints más utilizados en cada
módulo del sistema AriaTechShop-ERP, utilizando K6 como herramienta de
pruebas de carga, y verificar que se cumpla un percentil 95 (p95) menor
a 5 segundos.

## Instalación de K6

### Windows
choco install k6

Verificar instalación:
k6 version


## Endpoints asignados por integrante

| Integrante | Módulo | Endpoint | Método | Ruta |
|---|---|---|---|---|
| [Dávila Villa Laura Jacqueline] | Inventario | Listado de inventario | GET | `/inventory` |
| [López Orcí Brayan] | Ventas | Listado de ventas | GET | `/sales` |
| [Viera Salas Ramón] | Reparaciones | Listado de reparaciones | GET | `/repairs` |
| [Sarmiento Gil Javier Armando] | Administración/Seguridad | Login | POST | `/auth/store` |

## Consideraciones

- Las rutas `/inventory`, `/sales` y `/repairs` requieren sesión
  autenticada (middleware `auth`). El script de K6 deberá autenticarse
  primero antes de atacar el endpoint correspondiente.
- El endpoint `/repairs` corresponde a un componente Livewire; se
  evaluará su viabilidad para pruebas de carga con K6. En caso de no
  ser viable, se utilizará un endpoint alterno del backend.
- Cada integrante ejecutará su prueba con un mínimo de 5 Virtual Users
  (VUs), obteniendo el mayor número de métricas posible (p95, tasa de
  error, throughput, duración).

## Criterio de aceptación
- p95 < 5 segundos por endpoint evaluado.

## Nomenclatura de scripts
Cada integrante nombrará su script de prueba como:
[iniciales]_prueba.js

## Siguiente paso
Cada integrante ejecutará su prueba correspondiente y documentará los
resultados en un PR independiente, referenciando este plan.

2. Guarda el archivo y haz el commit (siguiendo su convención ci:):

bash
git add docs/plan-pruebas-carga.md
git commit -m "ci: agregar plan de implementación de pruebas de carga con K6"
git push origin ci/plan-pruebas-carga-k6

3. Abre el PR hacia main, con algo como:

Título: ci: plan de implementación de pruebas de carga con K6
Descripción: Closes #135 + un resumen breve del contenido