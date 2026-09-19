# Resultados de prueba de carga — Módulo de ventas

## 1. Información general

* **Herramienta:** Grafana k6
* **Versión:** k6 v2.2.0
* **Módulo evaluado:** Ventas
* **Endpoint:** `GET /api/sales`
* **URL de prueba:** `http://127.0.0.1:8000/api/sales`
* **Tipo de prueba:** Prueba de carga
* **Virtual Users (VUs):** 10
* **Duración:** 30 segundos
* **Archivo de prueba:** `performance/BL-sales.js`

## 2. Configuración

La prueba se configuró con 10 usuarios virtuales ejecutándose durante 30 segundos.

El criterio principal establecido para el tiempo de respuesta fue:

```text
p(95) < 5000 ms
```

También se estableció un límite para las solicitudes fallidas:

```text
http_req_failed < 1%
```

El script verifica que cada respuesta del endpoint tenga código HTTP 200.

## 3. Resultados obtenidos

| Métrica                 |  Resultado |
| ----------------------- | ---------: |
| Virtual Users máximos   |         10 |
| Iteraciones completadas |         60 |
| Solicitudes HTTP        |        120 |
| Solicitudes por segundo | 3.41 req/s |
| Tiempo promedio         |     2.81 s |
| Tiempo mínimo           |  394.85 ms |
| Mediana                 |     2.90 s |
| Tiempo máximo           |     3.04 s |
| p90                     |     2.96 s |
| **p95**                 | **3.00 s** |
| Solicitudes fallidas    |      0.00% |
| Checks exitosos         |       100% |
| Checks fallidos         |         0% |

## 4. Validación de umbrales

### Tiempo de respuesta

El umbral establecido fue:

```text
p(95) < 5 segundos
```

El resultado obtenido fue:

```text
p(95) = 3 segundos
```

Por lo tanto, el umbral configurado para el tiempo de respuesta fue cumplido durante la ejecución de la prueba.

### Solicitudes fallidas

El umbral establecido fue:

```text
http_req_failed < 1%
```

El resultado obtenido fue:

```text
http_req_failed = 0.00%
```

No se registraron solicitudes HTTP fallidas durante la prueba.

### Checks

Se realizaron 60 verificaciones del código de respuesta:

```text
checks_total: 60
checks_succeeded: 100%
checks_failed: 0%
```

Las respuestas verificadas fueron exitosas con código HTTP 200.

## 5. Conclusión

La prueba de carga del endpoint `GET /api/sales` se ejecutó utilizando 10 usuarios virtuales durante 30 segundos.

Durante la ejecución se realizaron 120 solicitudes HTTP y no se registraron solicitudes fallidas. El percentil 95 de tiempo de respuesta fue de 3 segundos, manteniéndose por debajo del límite establecido de 5 segundos.

Los resultados obtenidos permiten documentar el comportamiento del endpoint de ventas bajo la carga utilizada en esta prueba.
