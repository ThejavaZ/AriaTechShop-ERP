@echo off
set DB_FILE=..\server\database\database.sqlite

set /p ARCHIVO="Ingresa la ruta del archivo a restaurar (ej: backups\backup_2025-01-01.sqlite): "

if not exist "%ARCHIVO%" (
    echo ERROR: El archivo no existe.
    pause
    exit /b 1
)

copy %ARCHIVO% %DB_FILE%

echo Base de datos restaurada correctamente.
pause