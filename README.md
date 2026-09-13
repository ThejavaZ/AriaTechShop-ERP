# AriaTechShop-ERP

## Project Description

AriaTechShop-ERP is an Enterprise Resource Planning (ERP) application designed to manage various business processes for Aria Tech Shop. This project serves as a comprehensive example of integrating a modern frontend with a robust backend, providing tools for inventory management, sales tracking, and customer relations.

## Tech Stack

The application is built using a modern full-stack approach:

### Backend

- **Framework:** Laravel v12 (PHP)
- **Database:** (Please specify your preferred database, e.g., MySQL, PostgreSQL, SQLite)
- **Package Management:** Composer
- **Asset Bundling:** Vite

### Frontend

- **Framework:** React v19 (TypeScript)
- **Routing:** React Router DOM
- **Styling:** Tailwind CSS
- **Build Tool:** Vite
- **Package Management:** pnpm

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP:** Version 8.2 or higher
- **Composer:** Latest stable version
- **Node.js:** Version 18 or higher (LTS recommended)
- **pnpm:** (Recommended package manager for client-side dependencies) `npm install -g pnpm`
- **A database server:** (e.g., MySQL, PostgreSQL, or SQLite)

## Installation Guide

Follow these steps to set up and run the AriaTechShop-ERP application on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/AriaTechShop-ERP.git
cd AriaTechShop-ERP
```

### 2. Server Setup (Laravel Backend)

Navigate into the `server` directory:

```bash
cd server
```

a. **Install PHP Dependencies**

    ```bash
    composer install
    ```

b. **Environment Configuration**

    Copy the example environment file and generate an application key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Open the newly created `.env` file and configure your database connection and other environment variables.

c. **Database Migration**

    Run the database migrations to set up the necessary tables:

    ```bash
    php artisan migrate
    ```

d. **Install Node.js Dependencies (for Server Assets)**

    ```bash
    pnpm install # or npm install
    ```

e. **Build Server Assets**

    ```bash
    pnpm run build # or npm run build
    ```

### 3. Client Setup (React Frontend)

Navigate back to the root directory and then into the `client` directory:

```bash
cd ..
cd client
```

a. **Install Node.js Dependencies**

    ```bash
    pnpm install
    ```

b. **Build Client Assets (Optional, for production build)**

    ```bash
    pnpm run build
    ```

## Running the Application

### 1. Start the Server (Laravel)

Navigate to the `server` directory and start the Laravel development server. You can use the `composer dev` script to run both the Laravel server and Vite for hot-reloading server-side assets concurrently.

```bash
cd server
composer dev
```

Alternatively, to run them separately:

```bash
# In one terminal
php artisan serve

# In another terminal for asset hot-reloading
pnpm run dev # or npm run dev
```

### 2. Start the Client (React)

Navigate to the `client` directory and start the React development server:

```bash
cd client
pnpm run dev
```

The client application should now be accessible in your web browser, typically at `http://localhost:5173` (or similar, as indicated by Vite).

## Testing

### Server Tests

To run the Laravel backend tests:

```bash
cd server
php artisan test
```


##  Flujo de Trabajo y Reglas de Git (Git Workflow)

Para garantizar la estabilidad del proyecto en producción, el desarrollo sigue una estrategia basada en **GitHub Flow** respaldada por reglas de protección de ramas y plantillas estandarizadas.

---

###  Protección de la Rama Principal (`main`)

La rama `main` se encuentra protegida mediante una **Branch Protection Rule**. 

![Protección de Rama Main](./docs/images/branch-protection.png) <!-- Asegúrate de guardar la captura en tu repo y ajustar la ruta -->

* **Direct Push Bloqueado:** No se permite hacer `git push` directo a `main`.
* **Pull Request Obligatorio:** Todo cambio debe introducirse mediante un Pull Request (PR).
* **Aprobación Requerida:** Cada PR requiere como mínimo **1 aprobación (review)** de un integrante del equipo antes de ser fusionado (*Require approvals: 1*).
* **Descarte por Cambios Nuevos:** Si se suben nuevos commits a una rama de un PR activo, la aprobación previa queda desestimada automáticamente (*Dismiss stale pull request approvals*).

---

###  Convención de Nombres de Ramas

Las ramas deben crearse siguiendo el estándar definido en nuestros templates según el tipo de contribución:

* `fix/nombre-bug` para correcciones de errores.
* `feat/nombre-funcionalidad` para nuevas características.
* `refactor/modulo-nombre` para refactorización de código sin cambio funcional.
* `test/nombre-prueba` para agregar o mejorar la suite de pruebas.
* `ci/nombre-pipeline` para ajustes en automatizaciones y workflows de GitHub Actions.
* `perf/mejora-rendimiento` para optimizaciones.
* `docs/nombre-documento` para cambios en la documentación.

---

###  Estándar para Issues y Pull Requests

El repositorio cuenta con **Issue Templates** estandarizados en `.github/ISSUE_TEMPLATE` y una plantilla obligatoria de **Pull Request** (`PULL_REQUEST_TEMPLATE/pull_request_template.md`).

Al abrir un PR, se desplegará un formulario donde el colaborador debe completar obligatoriamente:
1. **Resumen del Cambio:** Explicación breve de lo modificado.
2. **Tipo de Cambio:** Selección con marcadores `[x]` acorde a los prefijos de las ramas (`fix`, `feat`, `refactor`, `test`, `ci`, `perf`, `docs`).
3. **Vínculo a la Issue:** Enlazar la issue correspondiente (ej. `Closes #12`).
4. **Evidencias:** Capturas o pruebas de ejecución que respalden el cambio.

---

###  Ciclo de Vida del Desarrollo (Paso a Paso)

1. **Crear una Issue:** Documentar el requerimiento o bug a resolver usando la plantilla correspondiente.
2. **Crear la rama:** `git checkout -b feat/mi-funcionalidad`
3. **Realizar Commits:** Mantener commits descriptivos siguiendo el tipo de cambio.
4. **Subir la rama:** `git push -u origin feat/mi-funcionalidad`
5. **Abrir Pull Request:** Llenar el formulario automático del PR.
6. **Code Review & Merge:** Solicitar revisión a un compañero. Una vez aprobada y pasando los tests de CI/CD, realizar el Merge.
