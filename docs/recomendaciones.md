# Recomendaciones

## RBAC
- Mantener el seeder actualizado cuando se agreguen nuevos módulos
- Documentar cada permiso nuevo en el seeder con comentarios
- Revisar permisos antes de cada release

## CI/CD
- Mantener las reglas de ESLint consistentes en todo el equipo
- Agregar pipeline de pruebas unitarias además del lint check
- No hacer merge a main/develop sin que el pipeline esté en verde

## Inventario (INV-10, INV-08)
- Usar eventos de Eloquent para registrar logs automáticamente
- No modificar stock directamente — siempre a través de movimientos
- Indexar la tabla de movimientos por producto_id y fecha para rendimiento

## Ventas (VEN-01.5, VEN-01.6)
- Usar transacciones de base de datos en todo el proceso de venta
- Centralizar el manejo de errores en un Handler dedicado
- Validar stock en el backend, no solo en el frontend

## General
- Usar variables de entorno para todas las credenciales sensibles
- Documentar cada endpoint en Postman o Swagger
- Hacer code review antes de aprobar cualquier PR