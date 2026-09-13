# Matriz de Trazabilidad del Proyecto AriaTechShop-ERP

## 1. Objetivo

Este documento presenta la matriz de trazabilidad del estado actual del proyecto **AriaTechShop-ERP**, relacionando las funcionalidades identificadas con sus módulos, rutas, controladores o componentes, modelos y estructuras de base de datos.

El objetivo es establecer una relación entre:

**Funcionalidad → Módulo → Ruta → Controlador/Componente → Modelo/Servicio → Base de datos**

La trazabilidad se utiliza como referencia para:

* conocer qué funcionalidades existen actualmente;
* identificar qué partes están implementadas, parcialmente implementadas o pendientes;
* relacionar funcionalidades con archivos concretos del repositorio;
* detectar inconsistencias entre rutas, controladores y base de datos;
* identificar áreas candidatas para aplicar Spec-Driven Development (SDD);
* facilitar la planeación de pruebas automatizadas y futuras modificaciones.

> Esta matriz describe el estado observado durante la ingeniería inversa del repositorio. No implica que una ruta existente garantice que la funcionalidad esté completamente implementada o probada.

---

# 2. Alcance

El análisis considera principalmente:

* Backend Laravel ubicado en `server/`.
* Frontend Next.js ubicado en `client/`.
* Rutas web y API.
* Controladores Laravel revisados.
* Componentes Livewire identificados.
* Modelos y migraciones de base de datos.
* Relaciones entre entidades.
* Servicios utilizados por los módulos revisados.
* Estructura actual de pruebas automatizadas.
* Áreas candidatas para implementar SDD.

Las conclusiones se basan en los archivos y estructuras identificados durante la ingeniería inversa. Cuando una implementación interna no fue revisada directamente, se indica como **"Implementación identificada; código no revisado"** en lugar de asumir que la funcionalidad está completa.

---

# 3. Criterios de estado

Se utilizan los siguientes estados:

| Estado                                              | Descripción                                                                                                               |
| --------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------- |
| **Implementado**                                    | Existe código funcional identificado para la operación analizada.                                                         |
| **Parcial**                                         | Existe código, pero presenta una implementación incompleta, inconsistencia o comportamiento que requiere revisión.        |
| **No implementado**                                 | Existe el método o punto de entrada, pero el código está vacío o no realiza la operación esperada.                        |
| **Implementación identificada; código no revisado** | La ruta, controlador o componente fue identificado, pero su implementación interna no fue revisada durante este análisis. |
| **No verificado**                                   | No existe evidencia suficiente en el análisis realizado para determinar el estado.                                        |

---

# 4. Matriz general de trazabilidad

| Funcionalidad               | Módulo         | Ruta / punto de entrada                | Controlador / componente                           | Modelo / servicio               | Estado                                          |
| --------------------------- | -------------- | -------------------------------------- | -------------------------------------------------- | ------------------------------- | ----------------------------------------------- |
| Inicio de sesión web        | Autenticación  | `GET /auth/login`, `POST /auth/store`  | `AuthController`                                   | `User`                          | Implementación identificada; código no revisado |
| Cierre de sesión            | Autenticación  | `POST /auth/logout`                    | `AuthController`                                   | `User`                          | Implementación identificada; código no revisado |
| Inicio de sesión API        | Autenticación  | `POST /api/login`                      | `Api\AuthController`                               | `User`, Sanctum                 | Implementación identificada; código no revisado |
| Registro API                | Autenticación  | `POST /api/register`                   | `Api\AuthController`                               | `User`                          | Implementación identificada; código no revisado |
| Página principal            | Inicio         | `GET /`                                | `HomeController`                                   | —                               | Implementado                                    |
| Consulta de usuarios        | Usuarios       | `GET /users`                           | `UserController@index`                             | `User`                          | Implementado                                    |
| Gráfica de usuarios         | Usuarios       | `GET /users-chart-data`                | `UserController@usersChart`                        | `users`                         | Implementado                                    |
| Crear usuario               | Usuarios       | Método `create`                        | `UserController@create`                            | `User`                          | Parcial                                         |
| Guardar usuario             | Usuarios       | Método `store`                         | `UserController@store`                             | `User`                          | No implementado                                 |
| Mostrar usuario             | Usuarios       | Método `show`                          | `UserController@show`                              | `User`                          | Parcial                                         |
| Editar usuario              | Usuarios       | Método `edit`                          | `UserController@edit`                              | `User`                          | No implementado                                 |
| Actualizar usuario          | Usuarios       | Método `update`                        | `UserController@update`                            | `User`                          | No implementado                                 |
| Eliminar usuario            | Usuarios       | Método `destroy`                       | `UserController@destroy`                           | `User`                          | No implementado                                 |
| Consulta de productos web   | Productos      | Método `index`                         | `ProductController@index`                          | `Product`                       | Parcial                                         |
| Crear producto              | Productos      | Método `create`                        | `ProductController@create`                         | `Product`                       | No implementado                                 |
| Guardar producto            | Productos      | Método `store`                         | `ProductController@store`                          | `Product`                       | No implementado                                 |
| Mostrar producto            | Productos      | Método `show`                          | `ProductController@show`                           | `Product`                       | No implementado                                 |
| Editar producto             | Productos      | Método `edit`                          | `ProductController@edit`                           | `Product`                       | No implementado                                 |
| Actualizar producto         | Productos      | Método `update`                        | `ProductController@update`                         | `Product`                       | No implementado                                 |
| Eliminar producto           | Productos      | Método `destroy`                       | `ProductController@destroy`                        | `Product`                       | No implementado                                 |
| Catálogo de productos API   | Productos      | `GET /api/products`                    | `Api\ProductController`                            | `Product`                       | Implementación identificada; código no revisado |
| Producto por slug API       | Productos      | `GET /api/products/{slug}`             | `Api\ProductController`                            | `Product`                       | Implementación identificada; código no revisado |
| Consulta de categorías API  | Categorías     | `GET /api/categories`                  | `Api\CategoryController`                           | `Category`                      | Implementación identificada; código no revisado |
| Inventario                  | Inventario     | `/inventory/*`                         | `InventoryController`                              | `Inventory`                     | Implementado                                    |
| Alta de inventario          | Inventario     | `POST /inventory`                      | `InventoryController@store`                        | `Inventory`                     | Implementado                                    |
| Reabastecimiento            | Inventario     | `/inventory/restock`                   | `InventoryController@restock/storeRestock`         | `Inventory`                     | Implementado                                    |
| Ajuste de existencias       | Inventario     | `/inventory/{id}/adjust-stock`         | `InventoryController@adjustStock/storeAdjustStock` | `Inventory`                     | Implementado                                    |
| Actualización de precio     | Inventario     | `/inventory/{id}/price`                | `InventoryController@edit/updatePrice`             | `Inventory`                     | Implementado                                    |
| Consulta de ventas          | Ventas         | `GET /sales`                           | `SaleController@index`                             | `Sale`, `SaleDetail`            | Implementado                                    |
| Detalle de venta            | Ventas         | `GET /sales/{id}`                      | `SaleController@show`                              | `Sale`, `SaleDetail`            | Parcial                                         |
| Crear venta                 | Ventas         | `POST /sales`                          | `SaleController@store`                             | `Sale`                          | Implementado                                    |
| Actualizar venta            | Ventas         | `PUT/PATCH /sales/{id}`                | `SaleController@update`                            | `Sale`                          | No implementado                                 |
| Eliminar venta              | Ventas         | `DELETE /sales/{id}`                   | `SaleController@destroy`                           | `Sale`                          | Implementado                                    |
| Gráfica de ventas           | Ventas         | `/sales-chart-data`, `/sales-chart`    | `SaleController@salesChart/chartView`              | `sales`                         | Implementado                                    |
| Registro de reparación      | Reparaciones   | `POST /api/repairs`                    | `RepairController@store`                           | `Repair`, `RepairStatusHistory` | Implementado                                    |
| Consulta de reparaciones    | Reparaciones   | `GET /api/repairs`                     | `RepairController@index`                           | `Repair`                        | Implementado                                    |
| Detalle de reparación       | Reparaciones   | `GET /api/repairs/{id}`                | `RepairController@show`                            | `Repair`                        | Implementado                                    |
| Actualización de reparación | Reparaciones   | `PUT /api/repairs/{id}`                | `RepairController@update`                          | `Repair`                        | Implementado                                    |
| Cambio de estado            | Reparaciones   | `POST /api/repairs/{id}/change-status` | `RepairController@changeStatus`                    | `Repair`, `RepairStatusHistory` | Implementado                                    |
| Eliminación de reparación   | Reparaciones   | `DELETE /api/repairs/{id}`             | `RepairController@destroy`                         | `Repair`                        | Implementado                                    |
| Envío de encuesta           | Reparaciones   | `POST /api/repairs/{id}/send-survey`   | `RepairController@sendSurvey`                      | `Repair`, `EmailApiService`     | Implementado                                    |
| Historial de estados        | Reparaciones   | Interno                                | `RepairController@changeStatus`                    | `RepairStatusHistory`           | Implementado                                    |
| Notificaciones por correo   | Notificaciones | `/api/notifications/*`                 | `NotificationController`                           | `EmailApiService`               | Implementación identificada; código no revisado |
| Lista de reparaciones web   | Reparaciones   | `GET /repairs`                         | `RepairsList` Livewire                             | `Repair`                        | Implementación identificada                     |
| Login frontend              | Frontend       | `/login`                               | `client/app/login/page.tsx`                        | API / Zustand                   | Implementado                                    |
| Página principal frontend   | Frontend       | `/`                                    | `client/app/page.tsx`                              | API / componentes               | Implementado                                    |
| Catálogo frontend           | Frontend       | `/products`                            | `client/app/products/page.tsx`                     | API / productos                 | Implementado                                    |

---

# 5. Trazabilidad de autenticación

## 5.1 Autenticación web

Las rutas relacionadas con autenticación web se encuentran fuera del middleware `auth`:

```text
GET  /auth/login
POST /auth/store
POST /auth/logout
```

Estas rutas utilizan:

```text
server/app/Http/Controllers/AuthController.php
```

La implementación interna del controlador no fue utilizada como evidencia detallada en esta matriz, por lo que se conserva como **implementación identificada; código no revisado**.

Las demás rutas web mostradas en `web.php` se encuentran dentro de:

```php
Route::middleware('auth')->group(function(){
    ...
});
```

Por lo tanto, el acceso a dichas funcionalidades requiere autenticación web.

---

## 5.2 Autenticación API

En `server/routes/api.php` se identificaron:

```text
POST /api/login
POST /api/register
```

como rutas públicas.

También existe un grupo protegido mediante:

```php
Route::middleware('auth:sanctum')->group(function(){
    ...
});
```

Dentro de este grupo se encuentran los recursos de usuarios y ventas API.

El proyecto utiliza Laravel Sanctum para la autenticación mediante API.

---

# 6. Trazabilidad del módulo de usuarios

### Archivo principal

```text
server/app/Http/Controllers/UserController.php
```

### Modelo

```text
server/app/Models/User.php
```

### Rutas identificadas

```text
GET /users
GET /users-chart-data
```

### Funcionalidades revisadas

#### Consulta de usuarios

`UserController@index` obtiene usuarios activos:

```php
User::where('is_active',1)->get();
```

Posteriormente devuelve:

```text
users.index
```

**Estado:** Implementado.

#### Gráfica de usuarios

`UserController@usersChart` obtiene la cantidad de usuarios creados por fecha y devuelve JSON.

**Estado:** Implementado.

#### Crear usuario

El método `create()` devuelve una vista:

```text
users.create
```

Sin embargo, la ruta correspondiente no aparece en el `web.php` revisado.

**Estado:** Parcial.

#### Guardar usuario

`store()` realiza validación de nombre:

```php
$data=$request->validate(["name"=>"required|string"]);
```

pero no persiste el usuario.

**Estado:** No implementado.

#### Editar, actualizar y eliminar

Los métodos `edit`, `update` y `destroy` se encuentran definidos, pero no contienen una implementación funcional.

**Estado:** No implementado.

---

# 7. Trazabilidad del módulo de productos

### Controlador web

```text
server/app/Http/Controllers/ProductController.php
```

### Controlador API

```text
server/app/Http/Controllers/Api/ProductController.php
```

### Modelo

```text
server/app/Models/Product.php
```

### Base de datos

```text
products
```

## 7.1 Implementación web

El método `index()` realiza una consulta de productos activos:

```php
Product::where('is_active')->get();
```

Sin embargo, en el código revisado no se identificó el retorno de una respuesta o vista.

Los métodos:

```text
create
store
show
edit
update
destroy
```

se encuentran sin implementación funcional.

Además, en las rutas web revisadas no se identificaron rutas para el recurso web de productos.

### Estado general

**Parcial / No implementado**, dependiendo de la operación.

---

## 7.2 Implementación API

En `api.php` se identificaron:

```text
GET /api/products
GET /api/products/{slug}
```

asociadas a `Api\ProductController`.

También se identificó:

```text
GET /api/categories
```

para categorías.

La existencia de estas rutas confirma que existe una capa API para catálogo, pero el contenido interno de esos controladores no fue revisado en el análisis utilizado para esta matriz.

Por ello se registra:

**Estado:** Implementación identificada; código no revisado.

---

# 8. Trazabilidad del módulo de inventario

### Controlador

```text
server/app/Http/Controllers/InventoryController.php
```

### Modelo / estructura relacionada

```text
inventories
```

### Rutas

```text
GET  /inventory
GET  /inventory/create
POST /inventory
GET  /inventory/restock
POST /inventory/restock
GET  /inventory/{id}/edit-price
PATCH /inventory/{id}/price
GET  /inventory/{id}/adjust-stock
PATCH /inventory/{id}/adjust-stock
```

El controlador contiene operaciones para:

* consultar inventario;
* mostrar formulario de alta;
* registrar elementos;
* consultar reabastecimiento;
* registrar reabastecimiento;
* mostrar edición de precio;
* actualizar precio;
* mostrar ajuste de stock;
* registrar ajuste de stock.

Los métodos identificados son:

```text
create
store
index
edit
updatePrice
restock
storeRestock
adjustStock
storeAdjustStock
```

### Estado

**Implementado.**

### Observación

La tabla `inventories` representa una estructura independiente de `products`. La tabla `sale_details` utiliza `inventory_id` para relacionar los detalles de venta con inventario.

Por lo tanto, la trazabilidad de ventas actualmente apunta a:

```text
SaleDetail → Inventory
```

y no directamente a:

```text
SaleDetail → Product
```

---

# 9. Trazabilidad del módulo de ventas

### Controlador

```text
server/app/Http/Controllers/SaleController.php
```

### Modelos

```text
Sale
SaleDetail
```

### Tablas

```text
sales
sale_details
```

## 9.1 Rutas web

El proyecto utiliza:

```php
Route::resource('sales', SaleController::class);
```

Esto genera las rutas RESTful estándar:

```text
GET       /sales
GET       /sales/create
POST      /sales
GET       /sales/{id}
GET       /sales/{id}/edit
PUT/PATCH /sales/{id}
DELETE    /sales/{id}
```

Además:

```text
GET /sales-chart-data
GET /sales-chart
```

## 9.2 Operaciones revisadas

### Consulta

`index()` obtiene:

```php
Sale::with('details')->get();
```

y devuelve:

```text
sales.index
```

**Estado:** Implementado.

### Detalle

`show()` obtiene la venta con sus detalles.

El código contiene una instrucción `return` duplicada, por lo que existe código inalcanzable después del primer retorno.

**Estado:** Parcial.

### Creación

`store()` utiliza:

```php
Sale::create($request->all());
```

y devuelve la venta en formato JSON con código HTTP 201.

**Estado:** Implementado.

### Actualización

El método `update()` requerido por `Route::resource()` no presenta una implementación funcional en el controlador revisado.

**Estado:** No implementado.

### Eliminación

`destroy()` elimina la venta mediante:

```php
Sale::destroy($id);
```

y devuelve una respuesta JSON.

**Estado:** Implementado.

### Gráficas

`salesChart()` genera datos agrupados por fecha.

`chartView()` devuelve la vista:

```text
sales.chart
```

**Estado:** Implementado.

---

# 10. Trazabilidad de ventas API

En `api.php` existe:

```php
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('sales', SaleController::class);
});
```

Esto genera las operaciones API REST para ventas utilizando el mismo `SaleController`.

La matriz resultante es:

| Operación        | Método    | Estado                                                  |
| ---------------- | --------- | ------------------------------------------------------- |
| Listar ventas    | GET       | Implementado, aunque `index()` devuelve una vista Blade |
| Mostrar venta    | GET       | Implementado                                            |
| Crear venta      | POST      | Implementado                                            |
| Actualizar venta | PUT/PATCH | No implementado                                         |
| Eliminar venta   | DELETE    | Implementado                                            |

### Observación importante

Existe una diferencia entre la intención de una API REST y la implementación actual de `SaleController@index`, ya que este método devuelve una vista Blade:

```text
sales.index
```

en lugar de una respuesta JSON.

Por lo tanto, aunque la ruta API existe, el comportamiento debe revisarse antes de considerarse completamente adecuado para consumo API.

---

# 11. Trazabilidad del módulo de reparaciones

### Controlador

```text
server/app/Http/Controllers/RepairController.php
```

### Componente web

```text
server/app/Livewire/Repairs/RepairsList.php
```

### Modelos

```text
Repair
RepairStatusHistory
User
```

### Servicio

```text
EmailApiService
```

### Rutas API

```text
GET    /api/repairs
POST   /api/repairs
GET    /api/repairs/{id}
PUT    /api/repairs/{id}
DELETE /api/repairs/{id}
POST   /api/repairs/{id}/change-status
POST   /api/repairs/{id}/send-survey
```

## 11.1 Consulta

`index()` permite:

* filtrar por estado;
* buscar por número de reparación;
* buscar por nombre del cliente;
* buscar por correo;
* buscar por dispositivo;
* ordenar por registros recientes;
* paginar resultados.

También carga las relaciones de cliente y técnico.

**Estado:** Implementado.

---

## 11.2 Registro

`store()`:

1. valida los datos;
2. inicia una transacción;
3. genera el número de reparación;
4. crea la reparación;
5. establece estado inicial `pending`;
6. crea el historial inicial;
7. registra al usuario que realizó el cambio;
8. envía el correo de registro;
9. confirma la transacción;
10. devuelve información de la reparación.

**Estado:** Implementado.

---

## 11.3 Consulta individual

`show()` carga la reparación junto con información relacionada y devuelve JSON.

**Estado:** Implementado.

---

## 11.4 Actualización

`update()` valida y actualiza los datos de la reparación.

**Estado:** Implementado.

---

## 11.5 Cambio de estado

`changeStatus()` valida los estados permitidos:

```text
pending
diagnosed
approved
in_progress
completed
delivered
cancelled
```

También:

* registra el estado anterior;
* registra el nuevo estado;
* permite notas;
* actualiza costo final;
* registra fecha de entrega;
* crea historial;
* registra al usuario que realizó el cambio;
* envía notificación;
* registra el envío del correo.

**Estado:** Implementado.

---

## 11.6 Eliminación

`destroy()` utiliza eliminación lógica mediante el modelo.

**Estado:** Implementado.

---

## 11.7 Encuesta

`sendSurvey()` verifica que la reparación esté entregada y posteriormente utiliza el servicio de correo para enviar la encuesta.

**Estado:** Implementado.

---

# 12. Trazabilidad de notificaciones

### Controlador

```text
server/app/Http/Controllers/Api/NotificationController.php
```

### Rutas

```text
POST /api/notifications/send-email
POST /api/notifications/send-welcome
POST /api/notifications/send-order-confirmation
POST /api/notifications/send-invoice
```

Se identificaron operaciones relacionadas con:

* envío de correo;
* correo de bienvenida;
* confirmación de pedido;
* envío de factura.

También existe un servicio:

```text
EmailApiService
```

utilizado directamente por el módulo de reparaciones.

La implementación interna de `NotificationController` no fue revisada con el mismo nivel de detalle que `RepairController`.

### Estado

**Implementación identificada; código no revisado.**

### Observación de seguridad

Las rutas de notificaciones identificadas en `api.php` se encuentran fuera del grupo:

```php
Route::middleware('auth:sanctum')->group(...)
```

Por lo tanto, en el archivo de rutas analizado no se observa una protección `auth:sanctum` para estos endpoints.

Esto debe revisarse antes de considerar estas operaciones listas para producción.

---

# 13. Trazabilidad del frontend

El frontend se encuentra en:

```text
client/
```

y utiliza:

* Next.js 16;
* React 19;
* TypeScript;
* Tailwind CSS;
* Zustand;
* lucide-react.

## 13.1 Página principal

Archivo:

```text
client/app/page.tsx
```

Se identificó una página principal que contiene:

* Hero;
* categorías;
* productos destacados.

**Estado:** Implementado.

---

## 13.2 Login

Archivo:

```text
client/app/login/page.tsx
```

Se identificó:

* formulario de inicio de sesión;
* comunicación con API;
* utilización de Zustand para el estado relacionado con autenticación.

**Estado:** Implementado.

---

## 13.3 Productos

Archivo:

```text
client/app/products/page.tsx
```

Se identificó una página de productos con:

* consulta de productos;
* filtros;
* categorías.

**Estado:** Implementado.

---

## 13.4 Otras secciones

Se identificaron directorios correspondientes a:

```text
client/app/about
client/app/register
client/app/profile
client/app/support
```

La existencia de estos directorios demuestra que forman parte de la estructura prevista del frontend, pero no se consideraron suficientes por sí mismos para afirmar el nivel de implementación de cada funcionalidad.

### Estado

**Estructura identificada; implementación individual pendiente de verificación.**

---

# 14. Trazabilidad con la base de datos

Las principales entidades funcionales identificadas son:

```text
users
categories
products
inventories
sales
sale_details
repairs
repair_status_histories
```

## 14.1 Usuarios y productos

La tabla `products` contiene:

```text
created_by
updated_by
deleted_by
```

relacionados con `users`.

Además:

```text
products.category_id → categories.id
```

con eliminación `set null`.

---

## 14.2 Usuarios y categorías

La tabla `categories` contiene:

```text
created_by
updated_by
deleted_by
```

relacionados con `users`.

---

## 14.3 Ventas y detalles

La relación principal es:

```text
sales.id
    ↓
sale_details.sale_id
```

Una venta puede tener múltiples detalles.

La eliminación de una venta utiliza relación en cascada para sus detalles.

---

## 14.4 Inventario y detalles de venta

La tabla `sale_details` contiene:

```text
inventory_id
```

relacionado con:

```text
inventories.id
```

La relación utiliza restricción para impedir eliminar un registro de inventario que tenga detalles de venta relacionados.

---

## 14.5 Reparaciones y usuarios

`repairs` contiene:

```text
user_id
assigned_to
```

ambos relacionados con usuarios.

Estas relaciones permiten representar al usuario asociado y al técnico asignado.

---

## 14.6 Reparaciones e historial

La tabla:

```text
repair_status_histories
```

contiene:

```text
repair_id
changed_by
status_from
status_to
notes
email_sent
```

La relación principal es:

```text
repairs.id
    ↓
repair_status_histories.repair_id
```

Una reparación puede tener múltiples cambios de estado.

---

# 15. Relaciones principales

La estructura funcional puede resumirse de la siguiente manera:

```text
USERS
 ├── PRODUCTS
 ├── CATEGORIES
 ├── REPAIRS
 └── REPAIR_STATUS_HISTORIES

CATEGORIES
 └── PRODUCTS

SALES
 └── SALE_DETAILS
       └── INVENTORIES

REPAIRS
 └── REPAIR_STATUS_HISTORIES
```

La representación visual completa se encuentra en:

```text
docs/er-diagram.md
```

---

# 16. Trazabilidad de pruebas

El backend cuenta con la infraestructura de pruebas de Laravel/Pest:

```text
server/tests/Pest.php
server/tests/TestCase.php
```

También existen los directorios:

```text
server/tests/Feature
server/tests/Unit
```

Sin embargo, durante la ingeniería inversa realizada no se identificaron casos de prueba implementados dentro de estos directorios.

### Estado actual

**Framework de pruebas configurado, casos de prueba pendientes de implementación.**

Esto representa una de las principales áreas para aplicar la estrategia de pruebas automatizadas solicitada en el proyecto académico.

---

# 17. Principales hallazgos de trazabilidad

A partir de la comparación entre rutas, controladores y base de datos se identificaron los siguientes puntos:

## 17.1 Funcionalidades con implementación parcial

* Gestión de usuarios.
* Gestión web de productos.
* Actualización de ventas.
* Detalle de ventas debido a código duplicado.
* Algunas secciones del frontend requieren verificación adicional.

---

## 17.2 Diferencias entre rutas y controladores

Existe una ruta:

```php
Route::resource('sales', SaleController::class);
```

que expone operaciones REST adicionales como `create`, `edit` y `update`, aunque algunos métodos correspondientes no están implementados.

Esto representa una diferencia entre la interfaz de rutas disponible y el nivel real de implementación del controlador.

---

## 17.3 Productos e inventario

El proyecto contiene dos estructuras diferenciadas:

```text
products
inventories
```

Mientras `products` se relaciona con categorías y usuarios para auditoría, `sale_details` utiliza `inventory_id`.

Esta diferencia debe considerarse al diseñar futuras funcionalidades de ventas, inventario y catálogo.

---

## 17.4 Ventas y usuarios

La tabla `sales` no contiene una clave foránea hacia `users`.

Por lo tanto, la estructura de base de datos analizada no registra mediante una relación FK qué usuario realizó cada venta.

Esto no significa que la aplicación no pueda manejar esa información por otro mecanismo, solamente que no se encuentra representada mediante una relación FK en la tabla `sales` analizada.

---

## 17.5 Reparaciones

El módulo de reparaciones presenta el flujo más completo entre los módulos revisados.

Existe trazabilidad entre:

```text
Repair
   ↓
RepairStatusHistory
   ↓
User
```

además de integración con correo electrónico.

Esto lo convierte en un candidato adecuado para una especificación SDD piloto.

---

## 17.6 Protección de endpoints

Los recursos de usuarios y ventas API están dentro de `auth:sanctum`.

En cambio, las rutas API de:

```text
notifications
repairs
```

se encuentran fuera del grupo protegido observado en `api.php`.

Debe revisarse si esta configuración es intencional o si representa una necesidad de mejora de seguridad.

---

# 18. Candidatos para Spec-Driven Development

Con base en la trazabilidad obtenida, se identifican tres módulos apropiados para realizar pilotos con SDD.

## 18.1 Piloto 1 — Inventario

### Justificación

El módulo cuenta con operaciones claramente identificables:

```text
Alta
Consulta
Reabastecimiento
Ajuste de stock
Actualización de precio
```

Además, sus reglas pueden expresarse fácilmente como especificaciones.

### Archivos relacionados

```text
server/app/Http/Controllers/InventoryController.php
server/app/Models/Inventory.php
server/routes/web.php
```

### Posibles especificaciones

* registrar producto de inventario;
* reabastecer existencias;
* ajustar existencias;
* actualizar precio;
* validar cantidades;
* controlar valores inválidos.

---

# 18.2 Piloto 2 — Reparaciones

### Justificación

Es uno de los módulos con mayor cantidad de reglas de negocio.

El flujo incluye:

```text
Registro
↓
Diagnóstico
↓
Aprobación
↓
En proceso
↓
Completado
↓
Entregado
```

Además existen:

* historial de estados;
* usuario que realiza el cambio;
* técnico asignado;
* costos;
* notificaciones;
* encuesta de satisfacción.

### Archivos relacionados

```text
server/app/Http/Controllers/RepairController.php
server/app/Models/Repair.php
server/app/Models/RepairStatusHistory.php
server/app/Livewire/Repairs/RepairsList.php
```

### Posibles especificaciones

* registrar reparación;
* cambiar estado;
* registrar historial;
* asignar técnico;
* enviar notificaciones;
* enviar encuesta al completar la reparación.

---

# 18.3 Piloto 3 — Productos y categorías

### Justificación

El catálogo representa una funcionalidad central de la tienda y permite trabajar con:

```text
Producto
Categoría
Stock
Precio
Costo
Estado
Auditoría
```

Además existe relación directa:

```text
categories → products
```

### Archivos relacionados

```text
server/app/Models/Product.php
server/app/Models/Category.php
server/app/Http/Controllers/ProductController.php
server/app/Http/Controllers/Api/ProductController.php
server/app/Http/Controllers/Api/CategoryController.php
client/app/products/page.tsx
```

### Posibles especificaciones

* consultar catálogo;
* filtrar productos;
* consultar producto por slug;
* asociar producto con categoría;
* controlar productos activos;
* administrar stock y precios.

---

# 19. Relación con los entregables SDD

La trazabilidad obtenida sirve como base para los siguientes documentos:

```text
docs/sdd-proposal.md
docs/sdd-implementation.md
docs/reverse-engineering.md
docs/er-diagram.md
docs/traceability.md
```

La ingeniería inversa proporciona la línea base del sistema existente antes de aplicar cambios mediante SDD.

La secuencia propuesta es:

```text
Repositorio actual
        ↓
Ingeniería inversa
        ↓
Matriz de trazabilidad
        ↓
Identificación de brechas
        ↓
Selección de módulos piloto
        ↓
Especificaciones SDD
        ↓
Tasks
        ↓
Implementación
        ↓
Pruebas
        ↓
Pull Request
```

---

# 20. Conclusión

La ingeniería inversa permitió identificar una arquitectura dividida entre un backend Laravel y un frontend Next.js, con módulos de autenticación, usuarios, productos, categorías, inventario, ventas, reparaciones y notificaciones.

Los módulos presentan diferentes niveles de madurez. Inventario y reparaciones cuentan con una implementación más amplia y trazable, mientras que usuarios, productos web y algunas operaciones de ventas presentan métodos incompletos o diferencias entre las rutas expuestas y la implementación de los controladores.

También se identificó que el proyecto cuenta con infraestructura para pruebas automatizadas, aunque no se observaron casos de prueba implementados en los directorios `Feature` y `Unit`.

La trazabilidad obtenida permite establecer una línea base del estado actual del sistema y facilita la selección de funcionalidades para aplicar Spec-Driven Development.

Como pilotos iniciales se proponen:

1. **Inventario**
2. **Reparaciones**
3. **Productos y categorías**

Estos módulos permiten trabajar con diferentes tipos de reglas de negocio y proporcionan suficiente alcance para demostrar el proceso:

**especificación → tareas → implementación → pruebas → trazabilidad → Pull Request.**
