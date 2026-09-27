# Pipeline CI/CD y entorno requerido

## 1. Flujo existente y complementación

### Flujo existente

El proyecto AriaTechShop-ERP cuenta, desde unidades anteriores, con un
pipeline de integración continua configurado mediante GitHub Actions,
que se ejecuta en cada Pull Request hacia la rama `main`:

- **Linting:** validación automática de la calidad del código con
  ESLint.
- **Pruebas automatizadas E2E:** ejecución de los 10 casos de prueba
  implementados con Playwright (TC-AUTH-*, TC-PROD-*, TC-SALES-*).
- **Branch Protection Rules:** bloquean el merge a `main` si alguna
  prueba falla o si no existe al menos una aprobación de un compañero
  de equipo.
- **Despliegue continuo del frontend:** una vez mergeado a `main`,
  Netlify detecta el nuevo commit y ejecuta automáticamente
  `pnpm install` → `pnpm build` → publicación en producción.

Este flujo cubre correctamente la integración continua (CI) y el
despliegue continuo (CD) del frontend, pero no contempla un paso
intermedio de liberación (release) donde validar la aplicación
completa (frontend + backend) antes de que los cambios lleguen a
producción.

### Complementación del pipeline

Para esta unidad, se complementa el pipeline existente agregando el
concepto de liberación entre las pruebas y el despliegue final:


- **Etapa de liberación (release):** se aprovecha la generación
  automática de Netlify Deploy Previews por cada Pull Request como
  entorno de liberación. GitHub Actions no necesita desplegar nada
  manualmente para esta etapa; su función es ejecutar las pruebas
  automatizadas y, una vez que estas pasan, permitir que el flujo
  continúe hacia el despliegue final en producción.

## 2. Entorno de liberación y despliegue

Para diferenciar claramente las etapas del ciclo de vida de un cambio,
se definen los siguientes entornos:

| Entorno | Propósito | Herramienta / Ubicación |
|---|---|---|
| Desarrollo | Trabajo local de cada integrante | Entorno local (`php artisan serve`, `pnpm dev`) |
| Pruebas | Ejecución de pruebas automatizadas (Playwright, K6, SonarQube) | GitHub Actions (CI) |
| Liberación (Staging) | Validación de la aplicación antes de producción | Netlify Deploy Preview |
| Despliegue (Producción) | Entorno final accesible a los usuarios reales | Netlify (rama `main`) |

### Entorno de liberación (Staging)

Netlify, al estar conectado al repositorio de GitHub, genera
automáticamente una URL temporal de vista previa por cada Pull Request
abierto hacia `main`, sin necesidad de configuración adicional. Esta
funcionalidad se utiliza como el entorno de liberación del proyecto:

1. Al abrir un Pull Request, Netlify construye automáticamente la
   aplicación (`pnpm install` + `pnpm build`) y la publica en una URL
   única de vista previa (ej. `deploy-preview-45--ariatechshop.netlify.app`).
2. Esa URL permite validar manualmente los cambios antes de
   aprobarlos, simulando el comportamiento real en producción.
3. En paralelo, el pipeline de GitHub Actions ejecuta las pruebas
   automatizadas (Playwright).
4. Una vez que las pruebas pasan y el PR es aprobado, se autoriza el
   merge a `main`.
5. Al mergear, Netlify despliega automáticamente esa misma versión a
   la URL de producción final.

### Herramienta de liberación continua

Como herramienta de liberación continua se utiliza GitHub Actions,
en conjunto con las Deploy Previews de Netlify. La liberación queda
vinculada directamente al entorno de despliegue: solo una versión que
pasó por las pruebas automatizadas y fue validada en su entorno de
staging (Deploy Preview) puede llegar a producción mediante el merge
a `main`.