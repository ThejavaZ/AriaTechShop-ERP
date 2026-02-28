@echo off
set DB_FILE=..\server\database\database.sqlite
set BACKUP_DIR=backups

mkdir %BACKUP_DIR% 2>nul

for /f "tokens=2 delims==" %%a in ('wmic OS Get localdatetime /value') do set dt=%%a
set FECHA=%dt:~0,4%-%dt:~4,2%-%dt:~6,2%_%dt:~8,2%-%dt:~10,2%

copy %DB_FILE% %BACKUP_DIR%\backup_%FECHA%.sqlite

echo Respaldo creado: %BACKUP_DIR%\backup_%FECHA%.sqlite
pause