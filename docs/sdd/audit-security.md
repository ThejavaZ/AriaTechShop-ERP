# Módulo adicional de Seguridad — Snyk

## 1. Justificación de la herramienta Snyk

Snyk es una herramienta de análisis de seguridad que escanea las
dependencias de un proyecto (paquetes de composer.json en el backend
y package.json en el frontend) en busca de vulnerabilidades conocidas,
reportadas en bases de datos públicas de seguridad (CVE).

Se eligió Snyk como módulo adicional de seguridad para
AriaTechShop-ERP por las siguientes razones:

- Cobertura multi-lenguaje: soporta tanto PHP/Composer (backend
  Laravel) como JavaScript/npm-pnpm (frontend Next.js).
- Integración nativa con GitHub.
- Plan gratuito disponible para proyectos académicos.
- Reportes accionables: sugiere la versión específica del paquete a
  la que se debe actualizar para resolver cada vulnerabilidad.

Esto complementa el análisis estático de código ya realizado con
SonarQube en la unidad anterior: SonarQube analiza la calidad del
código propio del proyecto, mientras que Snyk analiza las
vulnerabilidades en las librerías de terceros de las que depende el
proyecto.

## 2. Configuración e integración

### Instalación del CLI

    npm install -g snyk

### Autenticación

    snyk auth

Este comando abre el navegador para vincular la sesión de la terminal
con una cuenta de Snyk (creada de forma gratuita mediante GitHub).

### Escaneo del backend (Laravel — Composer)

    cd server
    snyk test --file=composer.lock

### Escaneo del frontend (Next.js — pnpm, monorepo)

    cd client
    snyk test --all-projects

Se utilizó la bandera `--all-projects` debido a que el proyecto
frontend está configurado como un workspace de pnpm, con múltiples
package.json internos.

## 3. Resultados del escaneo

| Proyecto | Total de issues | Critical | High | Medium | Low |
|---|---|---|---|---|---|
| Backend (Laravel) | 29 | 1 | 9 | 16 | 3 |
| Frontend (Next.js) | 44 | 2 | 22 | 17 | 3 |
| **Total combinado** | **73** | **3** | **31** | **33** | **6** |

### Hallazgos principales — Frontend

La mayoría de las vulnerabilidades de severidad alta y crítica
provienen de una única dependencia desactualizada: next@16.1.6. Snyk
recomienda actualizar a la versión next@16.3.3, lo cual resolvería 23
de las 44 vulnerabilidades detectadas, incluyendo ambas de severidad
crítica (Insecure Automated Optimizations y Directory Traversal).
Otras dependencias con vulnerabilidades de severidad alta incluyen
sharp (procesamiento de imágenes), nanoid y browserslist.

### Hallazgos principales — Backend

Se detectó 1 vulnerabilidad de severidad crítica y 9 de severidad alta
dentro de las dependencias gestionadas por Composer.

### Conclusión del escaneo

El análisis con Snyk permitió identificar un número considerable de
vulnerabilidades conocidas en las dependencias de ambos proyectos,
concentradas principalmente en librerías desactualizadas. Esto
confirma el valor de integrar este tipo de análisis como parte del
flujo de trabajo del proyecto: permite detectar y corregir riesgos de
seguridad en las dependencias de terceros antes de que lleguen a
producción, complementando el análisis de calidad de código propio ya
realizado con SonarQube.