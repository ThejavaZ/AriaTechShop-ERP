# Ingeniería inversa del proyecto AriaTechShop-ERP

## 1. Objetivo

El objetivo de esta ingeniería inversa es analizar y documentar el estado actual del proyecto **AriaTechShop-ERP**, identificando su estructura, tecnologías, arquitectura, módulos, funcionalidades, rutas, controladores y relaciones principales de la base de datos.

Este análisis servirá como referencia para las siguientes etapas del proyecto, principalmente para la implementación de **Spec-Driven Development (SDD)** y la definición de módulos piloto.

La documentación se realiza a partir del código y archivos existentes en el repositorio, sin modificar el comportamiento actual de la aplicación.

---

## 2. Estructura del proyecto

El proyecto está organizado como un repositorio que contiene un backend y un cliente web independiente:

```text
AriaTechShop-ERP/
├── server/
│   ├── app/
│   ├── database/
│   ├── routes/
│   ├── resources/
│   ├── tests/
│   ├── composer.json
│   └── ...
├── client/
│   ├── app/
│   ├── components/
│   ├── ...
│   ├── package.json
│   └── ...
├── scripts/
└── ...
```

### Backend

El directorio `server/` contiene la aplicación desarrollada con Laravel. Dentro de este directorio se encuentran los controladores, modelos, migraciones, rutas, vistas y configuración correspondiente al servidor.

### Cliente web

El directorio `client/` contiene una aplicación independiente desarrollada con Next.js, React y TypeScript.

Actualmente existen páginas implementadas para funcionalidades como inicio de sesión, productos y la página principal, además de directorios correspondientes a otras secciones del sistema.

### Scripts

El directorio `scripts/` contiene scripts auxiliares utilizados por el proyecto.

---

## 3. Tecnologías y herramientas

### Backend

| Tecnología      | Versión / referencia |
| --------------- | -------------------- |
| PHP             | ^8.2                 |
| Laravel         | ^12.0                |
| Laravel Sanctum | ^4.0                 |
| Livewire        | ^4.2                 |
| PHPUnit         | ^11.5.3              |
| Vite            | ^7.0.7               |
| Tailwind CSS    | ^4                   |
| Axios           | ^1.11                |

El backend utiliza **Laravel** como framework principal y **Eloquent ORM** para el acceso y manejo de los datos.

También se utilizan controladores web y controladores para API, además de componentes Livewire.

### Cliente web

| Tecnología   | Versión / referencia |
| ------------ | -------------------- |
| Next.js      | 16.1.6               |
| React        | 19.2.3               |
| TypeScript   | ^5                   |
| Tailwind CSS | ^4                   |
| Zustand      | ^5.0.11              |
| Lucide React | ^0.577.0             |
| ESLint       | Configurado          |
| pnpm         | Gestor de paquetes   |

El cliente utiliza React mediante Next.js y Zustand para el manejo de estado en determinadas funcionalidades.

---

## 4. Arquitectura actual

El proyecto utiliza una arquitectura dividida entre un **backend Laravel** y un **cliente web Next.js/React**.

De forma general, el backend se encarga de:

* Autenticación.
* Acceso y modificación de información.
* Lógica de las funcionalidades.
* Comunicación con la base de datos.
* Gestión de usuarios.
* Productos e inventario.
* Ventas.
* Reparaciones.
* Notificaciones.

El cliente web se encarga de proporcionar la interfaz con la que interactúa el usuario y consume las funcionalidades disponibles del backend.

### Backend

La estructura de Laravel sigue principalmente el patrón MVC:

```text
Ruta
  ↓
Controlador
  ↓
Modelo / Servicio
  ↓
Base de datos
```

En algunas funcionalidades también se utilizan componentes Livewire.

### Cliente

La aplicación `client/` utiliza Next.js y React para construir las diferentes páginas de la interfaz.

Entre las páginas verificadas se encuentran:

* Página principal.
* Inicio de sesión.
* Productos.

También existen directorios correspondientes a:

* About.
* Register.
* Profile.
* Support.

El contenido y grado de implementación de estas últimas se debe considerar de acuerdo con el código existente en cada sección.

---

## 5. Módulos y funcionalidades

A partir de las rutas, controladores, modelos y componentes encontrados en el proyecto, se identifican los siguientes módulos principales.

### 5.1 Autenticación

La autenticación cuenta con controladores tanto para las rutas web como para API.

Se identifican funcionalidades relacionadas con:

* Inicio de sesión.
* Registro.
* Cierre de sesión.
* Manejo de usuarios autenticados.
* Autenticación mediante API.

También se utiliza Laravel Sanctum para mecanismos de autenticación mediante tokens.

---

### 5.2 Productos

El sistema cuenta con un módulo para la gestión y consulta de productos.

Se identifican:

* `ProductController`
* Modelo `Product`
* Rutas relacionadas con productos.
* Página de productos en el cliente web.

La migración de productos también contiene relaciones con usuarios mediante los campos:

* `created_by`
* `updated_by`
* `deleted_by`

---

### 5.3 Categorías

Existe un módulo para la gestión de categorías.

Se identifican:

* `CategoryController`
* Modelo `Category`
* Rutas de categorías.
* Migración `categories`.

La tabla `categories` contiene, entre otros, los siguientes campos:

* `id`
* `name`
* `slug`
* `description`
* `is_active`
* `created_by`
* `updated_by`
* `deleted_by`
* `created_at`
* `updated_at`
* `deleted_at`

Las categorías son estructuralmente planas. No se identificó un campo `parent_category_id` en la migración verificada.

---

### 5.4 Inventario

El sistema cuenta con un módulo de inventario mediante `InventoryController`.

Se identificaron los siguientes métodos principales:

* `create`
* `store`
* `index`
* `edit`
* `updatePrice`
* `restock`
* `storeRestock`
* `adjustStock`
* `storeAdjustStock`

La tabla `inventories` contiene información relacionada con productos/inventario, incluyendo:

* `id`
* `name`
* `category`
* `price`
* `stock`
* `description`
* `created_at`
* `updated_at`

La estructura actual de `inventories` no contiene una clave foránea hacia `products`. Por lo tanto, ambas estructuras almacenan información relacionada con productos, pero actualmente no existe una relación directa mediante una clave foránea.

---

### 5.5 Ventas

El sistema cuenta con un módulo de ventas.

Se identifican:

* `SaleController`
* Modelo `Sale`
* Modelo `SaleDetail`
* Rutas web y API relacionadas con ventas.
* Tablas `sales` y `sale_details`.

La tabla `sales` contiene información como:

* Número de factura.
* Fecha de venta.
* Nombre del cliente.
* Teléfono.
* Correo electrónico.
* Subtotal.
* Impuestos.
* Total.
* Método de pago.

Los métodos de pago definidos actualmente son:

* `cash`
* `card`
* `transfer`
* `other`

La tabla `sale_details` se relaciona directamente con `sales` mediante `sale_id` y con `inventories` mediante `inventory_id`.

También almacena información como:

* Nombre del producto.
* Precio unitario.
* Cantidad.
* Precio total.

---

### 5.6 Reparaciones

El proyecto contiene un módulo para la gestión de reparaciones.

Se identifican:

* `RepairController`
* Modelo `Repair`
* Modelo `RepairStatusHistory`
* Componente Livewire `RepairsList`
* Rutas web y API relacionadas con reparaciones.

Las reparaciones tienen los siguientes estados definidos:

```text
pending
diagnosed
approved
in_progress
completed
delivered
cancelled
```

La tabla `repairs` cuenta con dos relaciones principales con usuarios:

* `user_id`: usuario asociado a la reparación.
* `assigned_to`: usuario al que se asigna la reparación.

Además, existe la tabla `repair_status_histories`, que permite registrar los cambios de estado de una reparación.

Esta tabla contiene información como:

* Reparación relacionada.
* Estado anterior.
* Estado nuevo.
* Notas.
* Usuario que realizó el cambio.
* Indicador de envío de correo.
* Fecha de creación y actualización.

Por lo tanto, el sistema no solamente conserva el estado actual de una reparación, sino que también cuenta con una estructura para registrar su historial de cambios.

---

### 5.7 Usuarios

El sistema cuenta con funcionalidades para administrar usuarios.

Se identifican:

* `UserController`
* Modelo `User`
* Rutas web y API.
* Tabla `users`.

Entre los campos principales de la tabla se encuentran:

* `id`
* `name`
* `email`
* `email_verified_at`
* `password`
* `role`
* `language`
* `status`
* `is_active`
* `remember_token`
* `created_at`
* `updated_at`
* `deleted_at`

Los valores numéricos utilizados en algunos campos, como `role` y `language`, deben interpretarse de acuerdo con la lógica definida en el proyecto, ya que la migración únicamente define sus tipos y valores predeterminados.

---

### 5.8 Notificaciones

El proyecto cuenta con un controlador de notificaciones y un servicio dedicado al envío de correos.

Se identifican:

* `NotificationController`
* `EmailApiService`

El servicio contiene funcionalidades relacionadas con:

* Envío de correo de bienvenida.
* Confirmación de pedidos.
* Actualización del estado de reparaciones.

---

### 5.9 Perfil

Existe un módulo relacionado con el perfil del usuario mediante:

* `ProfileController`
* Rutas correspondientes al perfil.
* Página `profile` en el cliente web.

---

### 5.10 Página principal

Existe un `HomeController` encargado de mostrar la página principal del backend.

El controlador actualmente tiene una responsabilidad reducida y devuelve la vista correspondiente al inicio.

En el cliente web, la página principal sí cuenta con contenido implementado, incluyendo elementos como:

* Hero.
* Categorías.
* Productos destacados.

---

## 6. Principales rutas y controladores

El backend cuenta principalmente con los siguientes grupos de rutas:

```text
server/routes/
├── api.php
├── web.php
├── auth.php
└── console.php
```

### Controladores API identificados

```text
Api/
├── AuthController
├── CategoryController
├── NotificationController
├── ProductController
└── UserController
```

### Controladores web identificados

```text
├── AuthController
├── CategoryController
├── HomeController
├── InventoryController
├── ProductController
├── ProfileController
├── RepairController
├── SaleController
└── UserController
```

También existe el componente:

```text
Livewire/
└── Repairs/
    └── RepairsList
```

El componente `RepairsList` se encuentra conectado a la ruta:

```php
Route::get('/repairs', RepairsList::class)->name('repairs.index');
```

---

## 7. Flujo general del sistema

De manera general, el flujo de una funcionalidad puede representarse de la siguiente forma:

```text
Usuario
   ↓
Cliente web / navegador
   ↓
Ruta
   ↓
Controlador o componente Livewire
   ↓
Modelo / Servicio
   ↓
Base de datos
   ↓
Respuesta
   ↓
Cliente web
   ↓
Usuario
```

En las funcionalidades que utilizan API, el cliente realiza una petición al backend y recibe la respuesta correspondiente.

En las funcionalidades web tradicionales, Laravel procesa directamente las rutas y controladores.

En el caso de las reparaciones, también interviene Livewire para determinadas interacciones de la interfaz.

---

## 8. Estado actual del proyecto

A partir de la revisión del repositorio se identifican diferentes niveles de implementación.

### Funcionalidades implementadas

Se identifican implementaciones para:

* Autenticación.
* Productos.
* Categorías.
* Inventario.
* Ventas.
* Reparaciones.
* Usuarios.
* Notificaciones.
* Perfil.
* Página principal.

El cliente web también cuenta con funcionalidades implementadas, entre ellas:

* Página principal.
* Inicio de sesión.
* Consulta de productos.

### Pruebas automatizadas

El proyecto tiene configurado Pest/PHPUnit.

Se identifican:

```text
server/tests/Pest.php
server/tests/TestCase.php
```

Sin embargo, los directorios:

```text
server/tests/Feature/
server/tests/Unit/
```

no contienen actualmente casos de prueba implementados.

Por lo tanto, existe una base de configuración para pruebas automatizadas, pero todavía es necesario desarrollar la suite de pruebas.

### SDD

No se identificó una implementación formal de **Spec-Driven Development** en el estado actual del repositorio.

La documentación SDD y los módulos piloto deberán desarrollarse como parte de las siguientes etapas del proyecto.

### CI/CD

No se identificó una implementación completa de pipelines de CI/CD como parte del estado actual analizado.

Esta parte corresponde a una etapa posterior del trabajo.

### Pruebas E2E

No se identificaron casos de pruebas End-to-End implementados mediante herramientas como Selenium, Playwright, Cypress o Katalon.

Esta funcionalidad queda como parte de las actividades posteriores.

---

## 9. Observaciones y áreas de mejora

Durante el análisis se identificaron algunos puntos que pueden ser considerados para futuras etapas del proyecto.

### Estructuras de productos e inventario

Actualmente existen las tablas `products` e `inventories`, ambas con información relacionada con productos.

Sin embargo, la tabla `inventories` no cuenta con una clave foránea hacia `products`.

Esto debe considerarse durante el análisis de requisitos y la definición futura de especificaciones, evitando asumir una relación que actualmente no existe en la base de datos.

### Cobertura de pruebas

Aunque el proyecto cuenta con la configuración necesaria para utilizar Pest/PHPUnit, todavía no se identificaron casos de prueba implementados.

Por lo tanto, una de las siguientes etapas deberá definir y desarrollar pruebas automatizadas para las funcionalidades principales.

### Separación de responsabilidades

El proyecto cuenta con controladores web y API para diferentes funcionalidades. Como parte de futuras iteraciones puede analizarse la distribución de responsabilidades entre controladores, modelos y servicios para mantener una estructura clara conforme aumente el sistema.

### Documentación técnica

El análisis actual permite establecer una base para documentar de forma más detallada:

* Arquitectura.
* Requisitos.
* Flujos.
* Relaciones entre entidades.
* Casos de prueba.
* Especificaciones de funcionalidades.

Esta información será utilizada como referencia para las siguientes actividades del proyecto.

---

## 10. Preparación para SDD

El análisis realizado permite identificar funcionalidades que pueden utilizarse posteriormente como módulos piloto para **Spec-Driven Development**.

Entre los candidatos se encuentran:

* Inicio de sesión.
* Gestión de productos.
* Inventario.
* Ventas.
* Reparaciones.

La selección definitiva del módulo piloto deberá realizarse durante la etapa de SDD, considerando factores como:

* Alcance de la funcionalidad.
* Claridad de los requisitos.
* Cantidad de reglas de negocio.
* Posibilidad de generar especificaciones.
* Facilidad para validar posteriormente mediante pruebas automatizadas.

La información obtenida en esta ingeniería inversa servirá como contexto inicial para generar las especificaciones de los módulos seleccionados.

---

## 11. Conclusión

La ingeniería inversa permitió identificar la estructura general del proyecto **AriaTechShop-ERP**, compuesto por un backend desarrollado con Laravel y un cliente web independiente desarrollado con Next.js, React y TypeScript.

El sistema cuenta con módulos relacionados con autenticación, usuarios, productos, categorías, inventario, ventas, reparaciones, notificaciones y perfil.

También se identificaron las principales relaciones de la base de datos y los componentes responsables de procesar las funcionalidades.

El proyecto presenta una base funcional sobre la cual pueden desarrollarse las siguientes etapas de la actividad académica. Entre ellas se encuentran la documentación mediante SDD, la implementación de módulos piloto, la creación de pruebas automatizadas, las pruebas End-to-End y la configuración de procesos de integración y despliegue continuo.

Este documento representa el estado del proyecto observado durante la ingeniería inversa y deberá actualizarse si la estructura o funcionalidades del sistema cambian durante las siguientes etapas.