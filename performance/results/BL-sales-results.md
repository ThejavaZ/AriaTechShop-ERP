# Resultados de Prueba de Carga — Módulo Ventas

## 1. Herramienta utilizada

**K6** — herramienta de pruebas de carga y rendimiento.

### Instalación

La instalación de K6 se realizó mediante Windows Package Manager (WinGet):

```powershell
winget install k6 --source winget
```

Para verificar la instalación:

```powershell
k6 version
```

Versión utilizada:

```text
k6 v2.2.0
```

En el entorno local, K6 quedó instalado en:

```text
C:\Program Files\k6
```

## 2. Endpoint probado

Se seleccionó el endpoint utilizado para consultar las ventas registradas:

```text
GET http://127.0.0.1:8000/api/sales
```

El endpoint fue verificado previamente y respondió correctamente con código HTTP `200`.

## 3. Script de prueba

Archivo:

```text
performance/BL-sales.js
```

Nomenclatura utilizada:

```text
BL-sales.js
```

Donde:

* `BL` corresponde a las iniciales del integrante.
* `sales` identifica el módulo probado.

## 4. Configuración de la prueba

La prueba se ejecutó con:

* **Virtual Users (VUs):** 10
* **Duración:** 30 segundos
* **Endpoint:** `GET /api/sales`
* **Requests:** 100
* **Objetivo:** obtener métricas de rendimiento bajo carga y verificar que el p95 sea menor a 5 segundos.

Comando utilizado:

```powershell
k6 run --summary-trend-stats="avg,min,med,max,p(90),p(95),p(99)" performance\BL-sales.js
```

## 5. Métricas obtenidas

### HTTP Request Duration

| Métrica        |  Resultado |
| -------------- | ---------: |
| Promedio (avg) |     3.38 s |
| Mínimo (min)   |  458.22 ms |
| Mediana (med)  |     3.53 s |
| Máximo (max)   |     3.64 s |
| p90            |     3.58 s |
| **p95**        | **3.59 s** |
| **p99**        | **3.61 s** |

### Requests y errores

| Métrica              | Resultado |
| -------------------- | --------: |
| HTTP requests        |       100 |
| Requests por segundo |    2.82/s |
| HTTP errors          |     0.00% |
| Requests con error   |  0 de 100 |
| Checks realizados    |        50 |
| Checks exitosos      |  50 de 50 |
| Checks fallidos      |         0 |

### Virtual Users

| Métrica                | Resultado |
| ---------------------- | --------: |
| VUs máximos            |        10 |
| VUs mínimos observados |         2 |
| VUs configurados       |        10 |

### Iteraciones

| Métrica                        | Resultado |
| ------------------------------ | --------: |
| Iteraciones completadas        |        50 |
| Iteraciones interrumpidas      |         0 |
| Duración promedio de iteración |    6.77 s |
| Duración mínima                |    3.98 s |
| Duración máxima                |    7.16 s |

### Red

| Métrica         | Resultado |
| --------------- | --------: |
| Datos recibidos |    331 kB |
| Datos enviados  |     10 kB |

## 6. Thresholds

Se configuraron los siguientes criterios:

```javascript
thresholds: {
    http_req_duration: ['p(95)<5000'],
    http_req_failed: ['rate<0.01'],
}
```

Resultados:

```text
✓ http_req_duration: p(95)=3.59s < 5s
✓ http_req_failed: rate=0.00% < 1%
```

## 7. Análisis

La prueba se realizó utilizando **10 Virtual Users durante 30 segundos**, superando el mínimo de 5 Virtual Users solicitado.

El endpoint `GET /api/sales` procesó **100 solicitudes** durante la ejecución, sin registrar errores HTTP.

El tiempo promedio de respuesta fue de **3.38 segundos**. El percentil 90 fue de **3.58 segundos**, el percentil 95 fue de **3.59 segundos** y el percentil 99 fue de **3.61 segundos**.

El criterio principal de rendimiento se cumplió:

```text
p95 = 3.59 s < 5 s
```

Además, la tasa de solicitudes fallidas fue de:

```text
0.00%
```

Por lo tanto, durante esta prueba local, el endpoint de consulta de ventas cumplió con el threshold establecido para el tiempo de respuesta y no presentó solicitudes fallidas.

## 8. Evidencia

La ejecución de K6 se documenta mediante una captura de pantalla donde se muestran las métricas obtenidas durante la prueba, incluyendo:

* 10 VUs.
* 30 segundos de ejecución.
* Requests procesadas.
* Promedio.
* Mínimo.
* Máximo.
* p90.
* p95.
* p99.
* Porcentaje de errores.
* Checks exitosos.

La captura será agregada como evidencia en el Pull Request correspondiente.

## 9. Conclusión

La prueba de carga del módulo de ventas fue ejecutada correctamente con **10 Virtual Users durante 30 segundos** sobre el endpoint `GET /api/sales`.

Los resultados obtenidos muestran un **p95 de 3.59 segundos**, por debajo del límite establecido de 5 segundos, además de una tasa de errores de **0.00%**.

Estos resultados corresponden a una ejecución realizada en el entorno local de desarrollo y sirven como evidencia del comportamiento del endpoint bajo la carga configurada.
