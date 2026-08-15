# Sugerencias de Expansión (TODO)

## INV-10 Sistema de bitácora y visualización de acciones
- [ ] Implementar eventos del modelo (Fat Model / Skinny Controller)
- [ ] Crear vista de bitácora ordenada por fecha descendente
- [ ] Restringir visualización solo a usuarios autenticados
- [ ] Agregar filtros por usuario, acción y rango de fechas

## INV-08 Gestión de movimientos de inventario
- [ ] Crear tabla inventory_movements con producto, tipo, cantidad, fecha
- [ ] Registrar movimientos automáticos en entradas y salidas
- [ ] Integrar con módulo de ventas y ajustes futuros
- [ ] Generar reportes de movimientos por periodo

## VEN-01.6 Manejo de errores (stock insuficiente)
- [ ] Validar stock antes de confirmar la venta
- [ ] Implementar rollback completo si falla cualquier paso
- [ ] Mostrar mensajes de error amigables en la UI
- [ ] Registrar log de error con detalle del fallo

## VEN-01.5 Registro de log de la acción
- [ ] Guardar log con: usuario, acción, fecha, ID de venta
- [ ] Integrar con sistema de bitácora del inventario
- [ ] Hacer logs accesibles desde panel de administración

## General
- [ ] Implementar panel de administración de roles desde la UI
- [ ] Agregar autenticación con Google OAuth
- [ ] Implementar notificaciones en tiempo real con WebSockets
- [ ] Implementar pruebas E2E con Cypress|