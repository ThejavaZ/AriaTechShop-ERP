# SKILL — Pruebas automáticas del test suite (Pest)

## Descripción

Capacidad para escribir y ejecutar pruebas automatizadas del backend de
AriaTechShop-ERP con **Pest** sobre PHPUnit, produciendo un suite hermético
(SQLite en memoria, servicios externos mockeados) y un reporte de ejecución.

## Cuándo usar

- Antes de abrir cualquier PR (gate de calidad).
- Al implementar nuevos requerimientos (cubrir criterios de aceptación de la spec).
- Al correr el reporte para el plan de pruebas.

## Qué produce

- Tests Pest en `server/tests/Feature/` y `server/tests/Unit/`.
- Reporte JUnit XML en `server/tests-report/junit.xml`.
- Suite verificado en GitHub Actions.

## Procedimiento

### 1. Preparar el entorno (una sola vez)

```bash
cd server
composer install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
```

> Si no existe: `composer require pestphp/pest --dev --with-all-dependencies`.

### 2. Escribir un test

- Usar `test('descripción en español', function () { ... })`.
- Emplear `RefreshDatabase` (ya configurado en `tests/Pest.php`).
- Para rutas JSON usar helpers: `$this->postJson()`, `getJson()`, `withHeader()`.
- **Mockear servicios externos** (correo, pagos, HTTP):

```php
$this->mock(EmailApiService::class)
    ->shouldReceive('sendEmail')
    ->andReturn(['success' => true]);
```

- Verificar persistencia con `assertDatabaseHas()` y respuestas con `assertStatus()`,
  `assertJsonStructure()`, `assertJsonCount()`.

### 3. Ejecutar

```bash
php artisan test                      # suite completo
php artisan test tests/Feature/Api    # solo API
php artisan test --log-junit=tests-report/junit.xml   # reporte JUnit
composer test                         # script del proyecto (config clear + test)
```

### 4. CI (automático)

`.github/workflows/test-suite.yml` ejecuta `composer install`, prepara el entorno,
corre el suite y sube el reporte JUnit como artefacto.

## Anti-patrones a evitar

- No usar la BD de desarrollo ni datos reales → siempre `:memory:`.
- No permitir llamadas de red reales (mockear Resend y similares).
- No escribir tests que dependan de fechas/hora reales del sistema.
- No dejar tests obsoletos referenciando rutas eliminadas (mantener el suite en verde).

## Validación del skill

- [ ] El suite se ejecuta y queda 100 % en verde.
- [ ] Los tests son herméticos (sin red, sin BD compartida).
- [ ] Existe reporte JUnit generado.