# SGJA - Prueba de Carga K6 - Módulo Administración / Seguridad

**Responsable:** Javier Armando Sarmiento Gil (SGJA)

## Descripción de la Prueba

Objetivo: Validar el rendimiento y la estabilidad del endpoint de autenticación `POST /api/login` bajo carga de 10 VUs durante 30 segundos.

## Endpoint Evaluado

- **Método:** POST
- **URL:** `http://localhost:8000/api/login`
- **Cuerpo de solicitud:** JSON con `email` y `password`

## Comando Ejecutado

```bash
k6 run --vus 10 --duration 30s --out json=SGJA_resultados.json server/tests/load/k6/SGJA_prueba.js
```

## Métricas Obtenidas

| Métrica | Valor |
|---------|-------|
| VUs (Virtual Users) | 10 |
| Tasa de error (failed requests) |  |
| p90 (90th percentile) |  |
| p95 (95th percentile) | < 5000ms (SLA) |
| p99 (99th percentile) |  |
| Tiempo promedio (avg) |  |
| Tiempo mínimo (min) |  |
| Tiempo máximo (max) |  |
| http_req_duration (p95) |  |

## Conclusión

- **SLA:** p95 < 5000ms (5 segundos)
- **Resultado:** [Insertar comparación - cumple / no cumple SLA]
- **Observaciones:** [Insertar comentarios sobre estabilidad, comportamiento bajo carga, etc.]

## Captura de Pantalla

![Resultados K6 - SGJA](placeholder.png)