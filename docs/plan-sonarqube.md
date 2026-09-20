Plan de implementación y análisis estático con SonarQube
1. Objetivo

Implementar una herramienta de análisis estático de código para el proyecto AriaTechShop-ERP, con el propósito de identificar problemas relacionados con seguridad, confiabilidad, mantenibilidad, cobertura y duplicación de código.

El análisis se realizó sobre el código correspondiente al PR #133, asociado a la rama:

feature/playwright-tests

El objetivo es contar con evidencia del análisis realizado mediante SonarQube como parte de la actividad de CI/CD y análisis estático del proyecto.

2. Herramientas utilizadas

Para realizar el análisis se utilizaron las siguientes herramientas:

SonarQube Community Build
SonarScanner CLI
Docker Desktop
Java JDK 21
PowerShell
Git

Versiones utilizadas:

SonarQube Community Build: 26.9.0.129388
SonarScanner CLI: 8.1.0.6389
Java: JDK 21
Docker: 29.4.0
3. Instalación de Java

SonarScanner requiere un entorno Java compatible.

Se utilizó Java JDK 21.

Para comprobar la instalación:

java -version

También se verificó la variable de entorno:

$env:JAVA_HOME

Resultado utilizado:

C:\Program Files\Java\jdk-21
4. Instalación de Docker

Se utilizó Docker Desktop para ejecutar SonarQube mediante un contenedor.

La instalación se verificó con:

docker --version

Resultado:

Docker version 29.4.0

También se verificó que el servicio de Docker estuviera funcionando correctamente.

5. Instalación de SonarQube

Se descargó la imagen oficial de SonarQube Community mediante:

docker pull sonarqube:community

Posteriormente se creó y ejecutó el contenedor:

docker run -d --name sonarqube -p 9000:9000 sonarqube:community

Para comprobar que el contenedor estuviera ejecutándose:

docker ps

SonarQube quedó disponible localmente mediante:

http://localhost:9000

La versión utilizada fue:

Community Build 26.9.0.129388
6. Configuración del proyecto en SonarQube

Dentro de SonarQube se creó el proyecto:

Nombre: AriaTechShop-ERP
Project Key: ariatechshop-erp

La rama principal configurada fue:

main

También se generó un token de autenticación para permitir que SonarScanner enviara los resultados al servidor local.

El token se mantuvo como variable de entorno y no se incluyó dentro del repositorio.

7. Instalación de SonarScanner

Se utilizó SonarScanner CLI para ejecutar el análisis desde PowerShell.

La versión utilizada fue:

SonarScanner CLI 8.1.0.6389

El programa quedó instalado en:

C:\sonar-scanner\sonar-scanner-8.1.0.6389-windows-x64

El ejecutable utilizado fue:

C:\sonar-scanner\sonar-scanner-8.1.0.6389-windows-x64\bin\sonar-scanner.bat

La instalación se verificó mediante:

& "C:\sonar-scanner\sonar-scanner-8.1.0.6389-windows-x64\bin\sonar-scanner.bat" --version
8. Código analizado

El análisis se realizó sobre el código correspondiente al PR #133.

Se verificó que el código utilizado correspondiera exactamente al commit:

9927080be09603366dc6ebd7e8055727d6966a3c

Commit:

fix(netlify): use npm lockfile

Rama:

feature/playwright-tests

PR:

#133
9. Configuración del análisis

Para realizar el análisis se especificaron los siguientes parámetros:

sonar.projectKey=ariatechshop-erp
sonar.host.url=http://localhost:9000
sonar.sources=server,client

Se excluyeron dependencias y directorios de pruebas del análisis principal:

**/vendor/**
**/node_modules/**
**/tests/**
**/tests-report/**
10. Ejecución del análisis

El análisis se ejecutó mediante SonarScanner desde PowerShell.

Comando utilizado:

& "C:\sonar-scanner\sonar-scanner-8.1.0.6389-windows-x64\bin\sonar-scanner.bat" `
  "-Dsonar.projectKey=ariatechshop-erp" `
  "-Dsonar.host.url=http://localhost:9000" `
  "-Dsonar.token=$env:SONAR_TOKEN" `
  "-Dsonar.sources=server,client" `
  "-Dsonar.exclusions=**/vendor/**,**/node_modules/**,**/tests/**,**/tests-report/**"

El análisis terminó correctamente con:

EXECUTION SUCCESS

Tiempo total aproximado:

1 minuto 25 segundos
11. Limitación de SonarQube Community Build

Inicialmente se intentó ejecutar el análisis utilizando los parámetros correspondientes a un Pull Request:

sonar.pullrequest.key=133
sonar.pullrequest.branch=feature/playwright-tests
sonar.pullrequest.base=main

Sin embargo, SonarQube informó que el análisis de Pull Requests requiere Developer Edition o superior.

Por este motivo, el análisis presentado en este documento corresponde a un análisis estático local del código del PR #133, utilizando SonarQube Community Build.

No se considera un análisis nativo de Pull Request dentro de SonarQube.

12. Resultados obtenidos

El análisis finalizó correctamente y SonarQube mostró:

Quality Gate
Passed
Security
Rating: B
Open issues: 7

La clasificación B indica que SonarQube detectó al menos un problema de bajo impacto relacionado con seguridad.

Reliability
Rating: D
Open issues: 96

La clasificación D corresponde a la presencia de problemas de alto impacto relacionados con confiabilidad.

Maintainability
Rating: A
Open issues: 100

La clasificación A corresponde a un nivel relativamente bajo de deuda técnica en relación con el tamaño del código analizado.

Accepted issues
0
Coverage
0.0%

SonarQube identificó:

820 líneas a cubrir
Duplications
0.5%

Sobre aproximadamente:

20k líneas
Security Hotspots
0

Security Review Rating:

A
13. Resumen de resultados
Métrica	Resultado
Quality Gate	Passed
Security	B
Security issues	7
Reliability	D
Reliability issues	96
Maintainability	A
Maintainability issues	100
Accepted issues	0
Coverage	0.0%
Lines to cover	820
Duplications	0.5%
Security Hotspots	0
Security Review Rating	A
14. Evidencia

Como evidencia del análisis se cuenta con una captura del dashboard de SonarQube donde se muestran los resultados del proyecto:

AriaTechShop-ERP

La evidencia muestra principalmente:

Quality Gate: Passed
Security: B
Reliability: D
Maintainability: A
Coverage: 0.0%
Duplications: 0.5%
Security Hotspots: 0
Security Review Rating: A

Esta captura permite comprobar visualmente que el análisis fue ejecutado y que SonarQube generó resultados para el proyecto.

15. Conclusión

La implementación local de SonarQube se realizó correctamente utilizando Docker, Java 21 y SonarScanner CLI.

El análisis estático del código correspondiente al PR #133 terminó exitosamente y generó métricas relacionadas con seguridad, confiabilidad, mantenibilidad, cobertura y duplicación de código.

El Quality Gate fue aprobado, aunque SonarQube identificó problemas abiertos de seguridad y confiabilidad, además de una cobertura de pruebas de 0.0%.

Debido a que se utilizó SonarQube Community Build, no fue posible realizar un análisis nativo de Pull Request mediante las propiedades sonar.pullrequest.*. Por lo tanto, los resultados documentados corresponden al análisis estático local del código del PR #133.

Los resultados quedan como evidencia del uso de una herramienta de análisis estático dentro del proyecto AriaTechShop-ERP.