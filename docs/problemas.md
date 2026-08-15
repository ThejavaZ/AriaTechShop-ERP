# Problemas Encontrados

## Problema 1 — Incompatibilidad de MariaDB con utf8mb4
**Issue relacionado:** RBAC  
**Descripción:** Al migrar las tablas de Spatie, MariaDB lanzaba error de índice muy largo  
**Causa:** MariaDB tiene límite de 1000 bytes en índices compuestos con utf8mb4  
**Solución:** Agregar Schema::defaultStringLength(125) en AppServiceProvider

## Problema 2 — Conflicto de AuthController
**Issue relacionado:** RBAC  
**Descripción:** El controlador Api/AuthController colisionaba con el de web  
**Causa:** Mismo nombre en namespaces distintos  
**Solución:** Crear controlador separado en App\Http\Controllers\Api\AuthController

## Problema 3 — Xdebug incompatible con PHP 8.3
**Issue relacionado:** Pruebas unitarias  
**Descripción:** El coverage report no funcionaba por versión incorrecta de Xdebug  
**Causa:** Xdebug instalado era para PHP 8.1  
**Solución:** Descargar versión TS x64 para PHP 8.3

## Problema 4 — Stock sin validación en ventas (VEN-01.6)
**Issue relacionado:** VEN-01.6  
**Descripción:** El sistema permite registrar ventas sin verificar stock disponible  
**Causa:** No existe validación previa al registro de la venta  
**Solución pendiente:** Implementar validación con rollback antes de confirmar la venta

## Problema 5 — Sin historial de cambios en inventario (INV-08)
**Issue relaciona
do:** INV-08  
**Descripción:** No existe registro de cuándo ni por qué cambió el stock de un producto  
**Causa:** La tabla de inventario solo guarda el stock actual  
**Solución pendiente:** Crear tabla inventory_movements con historial completo

## Problema 6 — Sin auditoría de acciones (INV-10, VEN-01.5)
**Issue relacionado:** INV-10, VEN-01.5  
**Descripción:** No hay registro visible de qué usuario realizó cada acción  
**Causa:** No existe sistema de logs ni bitácora implementado  
**Solución pendiente:** Implementar logs usando eventos de Eloquent